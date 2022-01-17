<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\API\ShowtimesController;
use App\Models\Order;
use App\Models\Show;
use App\Models\Showtime;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    //
    public function getStore($uid,Request $request)
    {

        $show = Show::findByUID($uid);
        $user = $request->user();
        $show_uid = $request->get('show_uid');

        $showtimes = Showtime::whereShowId(Show::realId($uid))->get();

//        $showtimes = $show->showtimes()->select(['id','datetime'])->get();
        $days = [];
        foreach ($showtimes as $showtime)
        {
            $day = date('Y-m-d', strtotime($showtime->datetime));
            if(in_array($day, array_keys($days)))
            {
                $days[$day][] = $showtime;
            }else{
                $days[$day] = [$showtime];
            }
        }

        return view('website.store',compact('show','days','user','showtimes'));
    }
}
