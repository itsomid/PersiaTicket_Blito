<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function result(Request $request, $result,$order_uid)
    {

        return view('payresult',['result' => $result, 'order_uid' => $order_uid]);
    }

}
