<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Log;
use Auth;
use Image;
use App\Http\Requests;
use Symfony\Component\DomCrawler\Form;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('profile', [
            'user' => Auth::user(),
        ]);
    }


    public function update(Request $request)
    {
        $user = $request->user();
        $check = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255'
        ];

//        $this->validate($request, [
//            'first_name' => 'required|max:255',
//            'last_name' => 'required|max:255',
//            'email' => 'required|email|max:255|unique:users',
//            'password' => 'required|min:6|confirmed',
//        ]);

        if($request->email != $user->email){
            $check['email'] = 'required|email|max:255|unique:users';
        }

        if(!empty($request->password)){
            if(Auth::attempt(['username' => $user->username, 'password' => $request->old_password])){
                $check['password'] = 'required|min:6|confirmed';
            }else{
                //return error
                $validator = Validator::make($request->all(), $check);
                $validator->errors()->add('old_password', 'Incorrect password');
                return redirect('profile')
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        Log::info($check);

        $this->validate($request, $check);

        $user->fill([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->save();

        return redirect('profile')->with('status', 'Profile updated!');
    }

    public function changePicture(Request $request)
    {
        $this->validate($request, ['photo' => 'required']);
        $file = $request->file('photo');
        $img = Image::make($file);
        $img->resize(320, 320);
        $img->save('public/images/users/user'.$request->user()->id.'.png');

        return redirect('profile')->with('status', 'Profile updated!');
    }
}
