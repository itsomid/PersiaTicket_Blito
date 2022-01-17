<?php

namespace App\Http\Controllers\Panel;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function index()
    {
        return view('panel.users', ['users' => User::all()]);
    }

    public function search(Request $request)
    {
        $term = $request->input('search-term');
        $user = $request->user();
        if ($user->access_level != 10)
            return abort(403);


        $users = User::where(function ($query) use ($term) {
            $query->where('first_name', 'LIKE', "%$term%")
                ->orWhere('email', 'LIKE', "%$term%")
                ->orWhere('mobile', 'LIKE', "%$term%")
                ->orWhere('last_name', 'LIKE', "%$term%");
        });
        return view('panel.users', ['users' => $users->get(), 'searchTerm' => $term]);
    }

    public function show($id)
    {
        return view('panel.single-user', ['user' => User::with(['orders', 'payments'])->find($id)]);
    }

    public function me(Request $request)
    {
        return view('panel.single-user', ['user' => User::with(['orders', 'payments'])->find($request->user()->id)]);
    }

    public function save(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            "email" => is_null($id) ? "email|unique:users,email" : "email",
            "mobile" => is_null($id) ? "required|digits:11|unique:users,mobile" : "required|digits:11",
            "password" => "nullable|min:6",
            "retype_password" => "same:password"
        ]);
        if ($validator->passes()) {


            if (is_null($id)) {
                $user = new User();
            } else {
                $user = User::find($id);
            }
            $user->mobile = $request->input("mobile");
            $user->first_name = $request->input("first_name");
            $user->last_name = $request->input("last_name");
            $user->email = !is_null($request->input("email")) ? $request->input("email") : $user->email;
            $password = $request->input('password');
            if (!is_null($password)) {
                $user->password = bcrypt($password);
            }
            if ($request->has('avatar')) {
                $user->avatar_url = asset('storage/' . $request->file('avatar')->store('images', 'public'));
            }



            // TODO: Gate to see if the logged in user can set access level or not
            if ($user->access_level != 10) {
                $user->access_level = $request->input('producer') ? 5 : ($user->access_level == 5 ? 0 : $user->access_level);
                $user->status = $request->input('status');
            }
            $user->save();
            return response()->redirectToRoute('users/show', ['id' => $user->id]);
        } else{
            return back()->withInput()->with(['error' => implode(',', $validator->errors()->all()), 'new_user' => true]);

    }


    }
}
