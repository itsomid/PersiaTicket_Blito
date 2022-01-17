<?php

namespace App\Http\Controllers\Website;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class testController extends Controller
{
    public function test(Request $request)
    {


        if ($request->isMethod('get')) {

             $cityid = $request->id;
            $request->session()->put('cityid',$cityid);

             return redirect()->refresh()->with('cityid',$cityid);
        }
        else{
            dd("omid");
        }
    }
}
