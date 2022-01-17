<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketsController extends Controller
{
    //
    public function reserve(Request $request, $uid)
    {
        /** @var User $user */
        $user = $request->user();
        return abort(406);
    }

    public function reserved(Request $request) {
        return $request->user()->reservedTickets;
    }
}
