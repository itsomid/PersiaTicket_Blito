<?php

namespace App\Http\Controllers;

use App\Classes\Abstracts\AbstractIPG;
use App\Models\Order;
use App\Models\Payment;
use App\User;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class ZarinPalController extends Controller implements AbstractIPG
{

    public $fake = false;

    public function createRequest($payment)
    {
        $result  = \Zarinpal::request(route('zarinpal/callback'),$payment->amount,'testing');
        $payment->authority = $result['Authority'];
        $payment->save();
        return ['redirect_url' => 'https://www.zarinpal.com/pg/StartPay/'.$result['Authority'].'/ZarinGate'];
    }

    public function redirectToBank($token)
    {
        return view('payments.saman.redirect',['token' => $token]);
    }

    public function callback(Request $request)
    {

        \Log::debug("payment callback: ".json_encode($request->all()));
        $authority = $request->input('Authority');
        $status = $request->input('Status');
        $payment = Payment::where('authority',$authority)->firstOrFail();
        $order = $payment->order;

        $failed = "http://buyfailed";
        $success = "http://buysuccessful";

        // temporary
        $agent = new Agent();
        if ($agent->isDesktop())
        {

            $order->agent = "website";
            $order->save();

            $failed = route('website/bank/result',['result' => 0, 'order_uid' => $payment->order->uid]);
            $success = route('website/bank/result',['result' => 1, 'order_uid' => $payment->order->uid]);

        }
        elseif($agent->isPhone()){
            if ($agent->is('iOS'))
            {
                $order->agent = "ios";
                $order->save();

            }
            elseif ($agent->is('AndroidOS')){
                $order->agent = "android";
                $order->save();

            }


            $failed = route('bank/result',['result' => 0, 'order_uid' => $payment->order->uid]);
            $success = route('bank/result',['result' => 1, 'order_uid' => $payment->order->uid]);

        }




        if(isset($payment->details()->external) && $payment->details()->external)
        {
            $failed = $payment->details()->scheme."://buyfailed";
            $success = $payment->details()->scheme."://buysuccessful";
            //$failed = $success;
        }else {

        }
        if($this->fake)
        {
//            $details = $payment->details();
//            $details->reference_id = 'fake-'.rand(1000,2000);
//            $payment->setDetails($details);
//            $payment->save();
//            $payment->setPaid();
//            return redirect($success);

        }
        if($status == "NOK")
        {
            $payment->save();
            $payment->setFailed();
            return redirect($failed);
        }
        // seems to be ok
        $result = \Zarinpal::verify('OK',$payment->amount,$authority);
        \Log::debug("payment callback verify result: ".json_encode($result));
        if($result['Status'] == "success")
        {
            //var_dump($result);
            //die();
            $details = $payment->details();
            $details->reference_id = $result["RefID"];
            $payment->setDetails($details);
            $payment->save();
            $payment->setPaid();
            return redirect($success);
        }
        $payment->setFailed();
        return redirect($failed);

    }
    public function getStatus($payment_id)
    {
        return "yeah :) $payment_id";
    }
}
