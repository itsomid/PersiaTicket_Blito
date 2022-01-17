<?php

namespace App\Http\Controllers\API;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CitiesController extends Controller
{
    //
    public function listCities($withShows = false)
    {
        if($withShows)
            return City::with(['shows' => function($query) {
                $query->where('status','enabled');
            }])->get();
        else
            return City::all();
    }
    public function getCity($city_id)
    {
        return City::find($city_id)->categories()->get();
    }
}
