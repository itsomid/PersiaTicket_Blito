<?php

namespace App\Http\Controllers\Panel;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    //
    public function getLogin()
    {
        return view('panel.login');
    }
    public function postLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "email" => "email|exists:users,email",
            "password" => "required|min:6"
        ]);

        if ($validator->passes()) {

            // grab credentials from the request
//            $credentials = $request->only('email', 'password');
//            $email =$request->input('email');
//            $pass = $request->input('password');
//             $user = User::whereId(1)->first();
//             $user->password = \Hash::make('behnood123456');
//             $user->save();
//             return md5($user->password);
            $userdata = array(
                'email'     => Input::get('email'),
                'password'  => Input::get('password')
            );

            if (\Auth::attempt($userdata)) {
                return redirect('/panel/dashboard');
            }
            else{
                return view('panel.login',['errors' => implode("\n",$validator->errors()->all())]);
            }
//            $user = User::whereEmail($email)->first();
//            if (!is_null($user) && ){
//                \Auth::login($user,true);
//            }
//            try {
//                // attempt to verify the credentials and create a token for the user
//                if (! $token = JWTAuth::attempt($credentials)) {
//                    return view('panel.login',['errors' => 'invalid_user']);
//                }
//            } catch (JWTException $e) {
//                // something went wrong whilst attempting to encode the token
//                return view('panel.login',['errors' => 'could_not_create_token']);
//            }
//            return "YESSSS";

        }

        return view('panel.login',['errors' => implode("\n",$validator->errors()->all())]);
    }
}
