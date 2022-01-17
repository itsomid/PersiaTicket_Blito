<?php

namespace App\Http\Controllers\Website;

use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function getProfile(Request $request)
    {
        $user = $request->user();
         $orders = $user->orders()->orderBy('created_at','DESC')->get();
//return $user->favorites;
        return view('website.profile', compact('user', 'orders'));
//
    }

    public function updateProfile(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'email' =>  ['required',Rule::unique('users')->ignore($request->user()->id)],
            'mobile' => ['digits:11','required', Rule::unique('users')->ignore($request->user()->id)],
            'avatar_url' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',

        ]);
        if ($validator->passes()) {
            $user = $request->user();
            $user->mobile = $request->input("mobile");
            $user->first_name = $request->input("first_name");
            $user->last_name = $request->input("last_name");
            $user->email = $request->input("email");
            if ($request->has('avatar')) {
                $user->avatar_url = asset('storage/' . $request->file('avatar')->store('images', 'public'));
            }
            $user->save();
            $request->session()->flash('message', 'اطلاعات شما با موفقیت بروز رسانی شد.');
            return \Redirect::route('website/profile');
        }else{

             $errorString = implode(" , ",$validator->messages()->all());
            $request->session()->flash('error',$errorString);
            return \Redirect::route('website/profile');
        }


    }

    public function newProfile(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'email' =>  ['required',Rule::unique('users')->ignore($request->user()->id)],
            'mobile' => ['digits:11','required', Rule::unique('users')->ignore($request->user()->id)],

        ]);
        if ($validator->passes()) {
            $user = $request->user();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->save();

            return "اطلاعات شما با موفقیت ثبت شد";
        }
        else{

            $errorString = implode(" , ",$validator->messages()->all());
//            $request->session()->flash('error',$errorString);
            return $errorString;
        }
    }
}
