<?php

namespace App\Http\Controllers\Panel;

use App\Models\Show;
use App\Models\Showtime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowtimesController extends Controller
{

    public function setStatus($uid, $status, Request $request)
    {
        $showtime = Showtime::findByUID($uid);
        $user = $request->user();
        if(!$user->isAdmin() || $user->id != $showtime->show->admin_id)
            return abort(403);

        $showtime->status = $status;
        $showtime->save();
        return response()->redirectToRoute('shows/show', ['id' => $showtime->show->uid]);

    }
}
