<?php

namespace App\Http\Controllers\Website;

use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PaymentController extends Controller
{
    public function result(Request $request,$result,$order_uid)

    {


        if (\Auth::check())
        {
            $order_id = Order::realId($order_uid);
             $order = Order::with('payments')->where('id',$order_id)->first();

             $payment = $order->allpayments()->first();

            if(is_null($order) || \Gate::denies('get-order',$order))
                return abort(404);
            if(\Gate::denies('get-order',$order))
                return abort(403);


            return view('website.payment',['result' => $result, 'order' => $order,'payment' => $payment]);
        }
        else{
            $user_id = Order::findByUID($order_uid)->user_id;
            $mobile = User::find($user_id)->mobile;

           return view('website.guest_payment',compact('mobile'));
        }
//        return $order_uid;


    }
}
