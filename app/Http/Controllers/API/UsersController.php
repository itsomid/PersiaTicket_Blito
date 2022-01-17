<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "email|unique:users,email"
        ]);
        if ($validator->passes()) {

            /** @var User $user */
            $user = $request->user();
            $user->updateProfile($request->input("first_name"),$request->input("last_name"),$request->input("email"),$user->mobile);
            /*    $user->first_name = !is_null($request->input("first_name")) ? $request->input("first_name") : $user->first_name;
                $user->last_name = !is_null($request->input("last_name")) ? $request->input("last_name") : $user->last_name;
                $user->email = !is_null($request->input("email")) ? $request->input("email") : $user->email;
              */  $user->save();
                return $user;
        }else {
                return response()->json(['errors' => $validator->errors()->all()],400);
        }
    }
    public function profile(Request $request)
    {
        return $request->user();
    }

    public function uploadAvatar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "avatar" => "required|image"
        ]);
        if ($validator->passes()) {

            $user = $request->user();
            $user->avatar_url = asset('storage/'.$request->file('avatar')->store('images', 'public'));
            $user->save();
            return ['avatar_url' => $user->avatar_url];
        }else {
            return response()->json(['errors' => $validator->errors()->all()],400);
        }
    }
    public function deleteAvatar(Request $request)
    {
        $user = $request->user();
        \Storage::delete(str_replace_first('storage/','', $user->avatar_url));
        $user->avatar_url = null;
        $user->save();
    }
}
