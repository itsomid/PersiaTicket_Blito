<?php

namespace App\Http\Controllers\API;

use App\Models\Show;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FavoritesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $request->user()->favorites;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "show_uid" => "required|size:10|string"
        ]);
        if ($validator->passes()) {

            $show = Show::findByUID($request->input('show_uid'));
            $user = $request->user();
            if (!is_null($show) && $user->favorites()->wherePivot('show_id',$show->id)->count() == 0 )
            {
                $user->favorites()->attach($show->id);
            };
            return response()->make('true',200,[]);
        }
        return response()->json(['errors' => $validator->errors()->all()],400);

    }


    public function destroy($uid, Request $request)
    {;
        $show = Show::findByUID($uid);
        $user = $request->user();
        if (!is_null($show)) {
            $user->favorites()->detach($show->id);
        }
        return response()->make('true',200,[]);
    }
}
