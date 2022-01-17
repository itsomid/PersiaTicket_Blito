<?php

namespace App\Http\Controllers\Panel;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    //
    public function index()
    {
        return view('panel.payments',['payments' => Payment::with(['user','order'])->paginate(20)]);
    }
}
