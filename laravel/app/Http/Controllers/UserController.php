<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Log;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('read:users');
    }

    public function index()
    {
        $adminCount = 0;
        $admins = UserRole::where('title', '!=', 'User')->get();
        foreach ($admins as $admin){
            $adminCount += $admin->users()->count();
        }
        return view('admin.user', [
            'users' => User::all(),
            'roles' => UserRole::all(),
            'admins' => $admins,
            'adminCount' => $adminCount,
            'right' => Auth::user()->role->modules()->where('url', 'users')->first()->pivot,
        ]);
    }

    public function store(Request $request){
        $this->validate($request, [
            'username' => 'required|max:255|unique:users',
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->user_role,
        ]);

        return redirect('admin/users')
            ->with('status', 'New User Successfully Created!');
    }

    public function update(Request $request){
        $role = UserRole::find($request->role_id);
        $user = User::find($request->user_id);
        $user->update([
            'role_id' => $request->role_id
        ]);

        return redirect('admin/users')
            ->with(
                'status',
                $user->first_name .' ' .$user->last_name .' Successfully changed to ' .$role->title .'!');
    }

    public function show()
    {
        //
    }

    public function test()
    {
        return json_encode("earl is real");
    }


    public function verifyEmail($id, $code){
        return 1;
//
    }
}
