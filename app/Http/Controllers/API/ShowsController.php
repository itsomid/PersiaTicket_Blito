<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use App\Models\Genre;
use App\Models\Show;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class ShowsController extends Controller
{
    public function show(Request $request, $uid) {
        /** @var Show $show */
        $show_id = Show::realId($uid);
        $show = Show::with('showtimes.scene')->whereId($show_id)->first();
        $token = JWTAuth::getToken();
        $user = null;
        if($token)
        {
            $user = JWTAuth::parseToken()->authenticate();
        }
        $show->isFavorite = !$user ? false : $user->favorites()->where('shows.id','=',$show_id)->count() == 1;
        return $show;
    }

    public function search(Request $request,$city_id)
    {
        $genre = $request->get('genre_id');
        $term = $request->get('term');

        $ids = null;
        if(!is_null($genre))
        {
            $genre = Genre::find($genre);
            $shows = $genre->shows()->select('genre_show.show_id')->get();
            $ids = [];
            foreach ($shows as $show )
            {
                $ids[] = $show->show_id;
            }
        }

        return Category::with(['shows' => function ($query) use($city_id,$term,$ids) {

            $query = $query->where('status', '=', "enabled");
            $query = $query->where('city_id', '=', $city_id);
            if(!is_null($ids))
            {
                $query = $query->whereIn('id',$ids);
            }
            if(!is_null($term))
            {
                $query = $query->where(function($query) use($term) {
                    $query->where('title','LIKE',"%$term%")
                        ->orWhere('artist_name','LIKE',"%$term%")
                        ->orWhere('subtitle','LIKE',"%$term%")
                        ->orWhere('description','LIKE',"%$term%");
                });
            }

        }])->get();

    }

    public function showtimes($uid) {
        /** @var Show $show */
        $show = Show::findByUID($uid);
        return $show->showtimes;
    }
}
