<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Promotion;
use App\Models\Showtime;
use App\Models\Ticket;
use App\User;
use function foo\func;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class
OrdersController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();

        $results = $user->orders()->with('tickets')->where('status','approved')->get();
        foreach ($results as $result)
        {
            $result->tickets->makeVisible('code');
        }
        return $results;
    }
    public function show(Request $request, $uid)
    {
        /** @var Order $order */
        $order = Order::findByUID($uid);
        if(is_null($order))
            return abort(404);
        if(Gate::denies('get-order',$order))
            return abort(403);
        $order->tickets->makeVisible('code');
        return $order;
    }
    public function pdf(Request $request, $uid)
    {
        /** @var Order $order */
        $order = Order::findByUID($uid);
        if(is_null($order))
            return abort(404);
        if(Gate::denies('get-order',$order))
            return abort(403);
        $html = view('ticket',['tickets' => $order->tickets])->render();
        $pdf = \App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html);
        return $pdf->inline();
    }

    public function guestReserveAndConfirm(Request $request)
    {

         $user = User::whereMobile($request->input('mobile'))->firstOrCreate(['mobile'=>$request->input('mobile')]);
//        \Auth::login($user);

        \Auth::onceUsingId($user->id);

        if ($request->input('chairless') != 'false'){
            $create = $this->createChairless($request,false);
        }
        else{
            $create = $this->create($request,false);
        }

        if($create['result'] == true)
        {
            return $this->confirm($request, $create['order']->uid);
        }
        else
        {
            return response()->json(['errors' => $create['errors']],$create['result']);
        }

    }

//    public function guestReserveAndConfirmChairless(Request $request)
//    {
//        $user = User::whereMobile($request->input('mobile'))->firstOrCreate(['mobile'=>$request->input('mobile')]);
////        \Auth::login($user);
//        \Auth::onceUsingId($user->id);
//
//        $create = $this->createChairless($request,false);
//
//        if($create['result'] == true)
//        {
//            return $this->confirm($request, $create['order']->uid);
//        }
//        else
//        {
//            return response()->json(['errors' => $create['errors']],$create['result']);
//        }
//    }


    public function createChairless(Request $request, $returnResponse = true)
    {
//         $ticket_number = $request->input('ticket_number');

        $ticket_number = $request->input('ticket_number');
        $showtime_uid = $request->input('showtime_id');
        $showtime_id = Showtime::findByUID( $showtime_uid)->id;
        $user = $request->user();
        $tickets = Ticket::whereStatus('available')->where('showtime_id',$showtime_id)->take($ticket_number)->get();

        $ids = [];

        foreach ($tickets as $ticket)
        {
            $ids[] = Ticket::realId($ticket->uid);
        }
         $result = Order::createOrderForTickets($ids,$user);
        if (is_numeric($result) && $result== 400)
        {
            if ($returnResponse)
                return abort(410);
            else
                return ['result' => false, 'code' => 410];
        }

        if (is_numeric($result) && $result == 406)
        {
            if ($returnResponse)
                return abort(406);
            else
                return ['result' => false, 'code' => 406];
        }
        if ($returnResponse)
            return response()->json($result);
        else
            return ['result' => 200, 'order' => $result];

    }
    public function create(Request $request, $returnResponse = true)
    {
        $validator = Validator::make($request->all(), [
            "ticket_uids" => "required|array"
        ]);
        if ($validator->fails())
        {
            if ($returnResponse)
                return response()->json(['errors' => $validator->errors()->all()],400);
            else
                return ['result' => 400,'errors' => $validator->errors()->all()];
        }


        $uids = $request->input('ticket_uids');
        $ids = [];
        foreach ($uids as $uid)
        {
            $ids[] = Ticket::realId($uid);
        }
        $user = $request->user();
        $result = Order::createOrderForTickets($ids,$user);

        if (is_numeric($result) && $result== 400)
        {
            if ($returnResponse)
                return abort(410);
            else
                return ['result' => false, 'code' => 410];
        }

        if (is_numeric($result) && $result == 406)
        {
            if ($returnResponse)
                return abort(406);
            else
                return ['result' => false, 'code' => 406];
        }
        if ($returnResponse)
            return response()->json($result);
        else
            return ['result' => 200, 'order' => $result];

    }
    public function confirm(Request $request, $uid)
    {
        /** @var Order $order */
//        $order = Order::findByUID($uid);

        $order = Order::find($uid);
       if(is_null($order))
           return abort(404);

       if(Gate::denies('pay-order',$order))
           return abort(403);

       $promotionCode = $request->get('promo_code');
       if(isset($promotionCode))
       {
            $promotion = Promotion::getQuery($request->user(),$order->show,$order->tickets[0]->showtime,$promotionCode)->first();
            if(!is_null($promotion))
            {
                $order->applyPromotion($promotion);
            }
       }

        if ($order->show->free == true)
        {
            $user = $request->user();
            $payment = new Payment();

            $payment->order_id = $order->id;
            $payment->amount = 0;
            $payment->user_id = $user->id;
            $payment->setDetails(['scheme' => 'no_payment','reserved' => true,'reference_id' => 'no_payment']);
            $payment->save();
            $payment->setPaid();
            $success = route('website/bank/result',['result' => 1, 'order_uid' => $payment->order->uid]);
            return response()->json(['redirect_url' => $success], 200);
        }

       if($order->source_id == 1)
       {

           $user = $request->user();
           $ipg = new \DefaultIPG();
           $payment = new Payment();
           $payment->order_id = $order->id;
           $payment->amount = $order->price;
           $payment->user_id = $user->id;
           $payment->setDetails(['scheme' => 'persiaticket']);
           $payment->save();
           return response()->json($ipg->createRequest($payment), 200);
       }
       else{
           // external source
           return (new ExternalSourcesController())->confirm($request,$uid);
       }

    }
}
