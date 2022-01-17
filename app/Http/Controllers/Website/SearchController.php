<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Genre;
use App\Models\Show;

class SearchController extends Controller
{
    public function searchView(Request $request,$search_key)
    {

        if (session('search_result')) {
            $categories = $request->session()->get('search_result');
        }
        else{
            $city_id = session('cityid');
            $categories = Category::with(['shows' => function ($query) use ($city_id, $search_key) {

                $query = $query->where('status', '=', "enabled");
                $query = $query->where('city_id', '=', $city_id);

                $query = $query->where(function ($query) use ($search_key) {
                    $query->where('title', 'LIKE', "%$search_key%")
                        ->orWhere('artist_name', 'LIKE', "%$search_key%")
                        ->orWhere('subtitle', 'LIKE', "%$search_key%")
                        ->orWhere('description', 'LIKE', "%$search_key%");
                });
            }])->get();
        }
        $cities = City::has('shows')->get();
        $genres = Genre::has('shows')->get();
        $showhasgenres = Show::with('genres')->get();
        return view('website.search',compact('categories','cities','genres', 'showhasgenres'));
    }
}
