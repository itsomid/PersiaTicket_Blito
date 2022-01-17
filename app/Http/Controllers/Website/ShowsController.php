<?php

namespace App\Http\Controllers\Website;

use App\Models\Show;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class ShowsController extends Controller
{
    //
    public function getShow($uid,Request $request)
    {
//        $ldate = date('Y-m-d');

        $show = Show::findByUID($uid);

        if(\Auth::check()){
             $user_favorites = $request->user()->favorites;
                $fav = json_decode($user_favorites,true);
            if ($fav == []){
                $favorite_uid = [];
            }
            else {
                foreach ($user_favorites as $user_favorite) {
                    $favorite_uid[] = $user_favorite->uid;
                }
            }
        }
        else{
            $favorite_uid = [];
        }

        return view('website.event', compact('show','favorite_uid'));
    }
}