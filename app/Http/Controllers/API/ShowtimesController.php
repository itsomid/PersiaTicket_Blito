<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Showtime;
use App\Models\ShowTimeCache;
use App\Models\Ticket;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShowtimesController extends Controller
{
    //

    public function showtime($uid)
    {
//        return response()->json(1);
        $showtime = Showtime::findByUID($uid);
        if ($showtime->show->auto_selection == 1){

            $showtime_id = Hashids::connection('showtime')->decode($uid);

            return response()->json([new ShowTimeCache($showtime_id[0]),'auto_selection'=>true,'price'=>$showtime->tickets[0]->price,'chair_count'=>count($showtime->tickets)]);
        }
        else{
            $showtime_id = Hashids::connection('showtime')->decode($uid);
            if(count($showtime_id) > 0)
            {
                return response()->json(new ShowTimeCache($showtime_id[0]));
            }
        }

        return abort(404);
    }

}
