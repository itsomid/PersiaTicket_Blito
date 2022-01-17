<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentsController extends Controller
{
    public function my(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        return $user->payments()->with('order:id')->orderBy('created_at','DESC')->get();
    }
}
