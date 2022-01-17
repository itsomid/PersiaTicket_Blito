<?php

namespace App\Http\Controllers\API;

use App\Seeb\shSMS;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "mobile" => "required|digits:11"
        ]);
        if ($validator->passes()) {
            $mobile = $request->input('mobile');
            $code = User::generateCode();
            $user = User::whereMobile($mobile)->first();
            $isNew = false;
            if (is_null($user)){
                $isNew = true;
                $user = User::create(['mobile' => $mobile]);
            }elseif ($user->status == 'pending') {
                $isNew = true;
            }elseif ($user->status == 'disabled')
            {
                return response()->json(['errors' => 'حساب کاربری شما مسدود است. لطفا با پشتیبانی تماس حاصل فرمایید'],400);
            }
            $user->code = $code;
            //SMS code‌
            shSMS::sendVerification($user->mobile,$code);
            $user->save();

            return response()->json(['is_new' => $isNew, 'code_for_test' => $code]);
        }
         return response()->json(['errors' => $validator->errors()->all()],400);

    }

    public function continueLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "email|unique:users,email",
            "mobile" => "required|digits:11|exists:users,mobile",
            "code" => "required|digits:5|exists:users,code"
        ]);
        if ($validator->passes()) {

            $user = User::where('mobile', '=',$request->input('mobile'))->where('code','=',$request->input('code'))->first();
            if (!is_null($user)) {
                   $user->code = null;
                   $user->status = "enabled";
                   $errors = $user->updateProfile($request->input("first_name"),$request->input("last_name"),$request->input("email"),$user->mobile);

                return ['user' => $user, 'token' => JWTAuth::fromUser($user)];
            }else {
                return response()->json(['errors' => $validator->errors()->all()],400);
            }


        }
        return response()->json(['errors' => $validator->errors()->all()],400);
    }

}
