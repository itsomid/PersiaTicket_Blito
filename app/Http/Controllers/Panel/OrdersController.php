<?php

namespace App\Http\Controllers\Panel;

use App\Mail\TicketsReady;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class OrdersController extends Controller
{
    //
    public function index(Request $request)
    {
        $user = $request->user();
        if($user->access_level == 10)
            return view('panel.orders',['orders' => Order::orderBy('id','DESC')->paginate(20)]);
        return view('panel.orders',['orders' => $user->ownShowsOrders()->orderBy('id','DESC')->paginate(20)]);
    }
    public function search(Request $request)
    {
        $user = $request->user();
        $term = $request->input('search-term');
        $orders = $user->ownShowsOrders();
        if($user->access_level == 10)
            $orders = Order::query();
        /*$orders = $orders->where(function($query) use($term) {
            $query->where('uid','LIKE',"%$term%");
        });*/
        $orders->where('id','like','%'.$term.'%');
        return view('panel.orders',['orders' => $orders->paginate(20),'searchTerm' => $term]);
    }
    public function download($uid)
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
        return $pdf->download();
    }
    public function cancel($id, Request $request)
    {
        $order = Order::find($id);
        if (Gate::allows('edit-order',$order))
        {
            $order->cancel();
            return redirect()->back();
        }else
        {
            return redirect()->back(400);
        }

    }
    public function resend(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        $email = $request->input('email');
        Mail::to($email)->send(new TicketsReady($order));
        return response('',200);
    }
    public function mine(Request $request)
    {

        return view('panel.orders',['orders' => $request->user()->orders()->paginate(20)]);
    }
}
