<?php

namespace App\Http\Controllers\API;

use App\Classes\Seeb\Vendors\SeebTiwall;
use App\Models\Order;
use App\Models\Show;
use App\Models\Showtime;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ExternalSourcesController extends Controller
{

    public function seatMapForExternalShowtime($showtime_uid)
    {
        /** @var Showtime $showtime */
        $showtime = Showtime::findByUID($showtime_uid);
        if(is_null($showtime))
            return abort(404);
        if($showtime->source_id == 1)
            return abort(400);

        switch ($showtime->source_id)
        {
            case 2:
                //tiwall
                $seebTiwall = new SeebTiwall();
                $seatmap = $seebTiwall->retrieveShowSeatmapHtml($showtime->show->source_details['urn'],$showtime->source_related_id);
                //var_dump($seatmap);
                return response()->json(json_decode($seatmap));
                break;
        }
    }

    public function reserve(Request $request, $returnResponse = true)
    {
        $validator = Validator::make($request->all(), [
            "seats" => "required",
            "showtime_uid" => "required"
        ]);
        if ($validator->passes()) {

            $showtime_id = Showtime::realId($request->input('showtime_uid'));
            if(is_null($showtime_id))
            {
                if ($returnResponse)
                    return abort(404);
                else
                    return false;
            }
            /** @var Showtime $showtime */
            $showtime = Showtime::with('show')->find($showtime_id);
            switch ($showtime->source_id)
            {
                case 1:
                    if ($returnResponse)
                        return abort(400);
                    else
                        return ['result' => 400];
                    break;
                case 2:
                    //tiwall
                    $tiwall = new SeebTiwall();
//                    return $request->input('seats');
                    $response = $tiwall->reserveTickets(urlencode($request->input('seats')),$showtime,$request->user());

                    if($response->getStatusCode() == 200)
                    {
//                        return $response->getBody()->getContents();
                         $result = json_decode($response->getBody()->getContents());
                        //return response()->json(["result" => $result, "ok" => $result->ok]);
//                        return response()->json(["result" => $showtime->show->id, "ok" => $request->input('seats')]);
                        if($result->ok == true)
                        {
                            $order = Order::createOrderForExternalTickets($showtime,$request->user(),$result->data->seats,$result->data->total_price,$result->data->reserve_id,$result->data->trace_number);
                            $theOrder = json_decode(json_encode($order),true);
                            $theOrder['tickets'] = $order->tickets;
                            if ($returnResponse)
                                return $theOrder;
                            else
                                return ['result' => 200, 'order' => $theOrder];
                        }else {

                            if ($returnResponse)
                                abort($result->error->code);
                            else
                                return ['result' => $result->error->code];
                        }
                        return $result;
                    }
                    if ($returnResponse)
                        return abort($response->getStatusCode());
                    else
                        return ['result' => $response->getStatusCode()];

                    break;
            }
            if ($returnResponse)
                return abort(204);
            else
                return ['result' => 204];

        }
        if ($returnResponse)
            return response()->json(['errors' => $validator->errors()->all()],400);
        else
            ['result' => 4004, 'errors' => $validator->errors()->all()];
    }


    public function guestReserveAndConfirm(Request $request)
    {
        $user = User::whereMobile($request->input('mobile'))->firstOrCreate(['mobile'=>$request->input('mobile')]);
        \Auth::onceUsingId($user->id);
        $reserve = $this->reserve($request, false);
        if ($reserve['result'] == 200)
        {
            return $this->confirm($request,$reserve['order']['uid']);
        }elseif ($reserve['result'] == 4004)
        {
            return response()->json(['errors' => $reserve['errors']],400);
        }else
        {
            abort($reserve['result']);
        }

    }
    public function confirm(Request $request, $uid)
    {
        // it is a inter-controller method
        /** @var Order $order */
        $order = Order::findByUID($uid);
        if(is_null($order))
            return abort(404);
        $user = $request->user();
        switch ($order->source_id) {

            case 2:
                // Tiwall

                return ['redirect_url' => route('pay/external',['order_uid' => $order->uid])];
                break;
        }
    }

    public function pay($order_uid,$mobile = false) {
        $order = Order::findByUID($order_uid);
         (new SeebTiwall())->paymentURLForOrder($order,$mobile ? 'persiaticket' : '');
        return redirect()->to((new SeebTiwall())->paymentURLForOrder($order,$mobile ? 'persiaticket' : ''));
    }
}
