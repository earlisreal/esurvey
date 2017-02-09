<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
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
            'last_name' => 'required|max:255',
            'gender' => 'required|max:255',
            'birthday' => 'required|max:255',
            'country' => 'required|max:255',
            'state' => 'required|max:255',
            'city' => 'required|max:255',
        ];

//        $this->validate($request, [
//            'first_name' => 'required|max:255',
//            'last_name' => 'required|max:255',
//            'email' => 'required|email|max:255|unique:users',
//            'password' => 'required|min:6|confirmed',
//        ]);

        if ($request->email != $user->email) {
            $check['email'] = 'required|email|max:255|unique:users';
        }

        if (!empty($request->password)) {
            Log::info("password changed");
            if (Auth::attempt(['username' => $user->username, 'password' => $request->old_password])) {
                $check['password'] = 'required|min:6|confirmed';
            } else {
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
            'gender' => $request['gender'],
            'phone' => $request->phone,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'birthday' => Carbon::parse($request->birthday)->toDateString(),
        ])->save();

        if (!empty($request->password)) {
            $user->fill([
                'password' => Hash::make($request->password),
            ])->save();
        }

        return redirect('profile')->with('status', 'Profile updated!');
    }

    public function changePicture(Request $request)
    {
        $this->validate($request, ['photo' => 'required']);
        $file = $request->file('photo');
        $img = Image::make($file);
        $img->resize(320, 320);
        $img->save('public/images/users/user' . $request->user()->id . '.png');

        return redirect('profile')->with('status', 'Profile updated!');
    }

    public function verify()
    {
        if (Auth::user()->verified) return redirect('home');

        return view('user.verify', ['user' => Auth::user()]);
    }

    public function resendConfirmation(Request $request)
    {
        $activationCode = str_random(50);
        $user = $request->user();
        $user->update([
            'activation_code' => $activationCode
        ]);
        try {
            Mail::send('emails.activation',
                [
                    'code' => $user->activation_code,
                    'id' => $user->id,
                    'name' => $user->first_name . ' ' . $user->last_name
                ], function ($message) use($user) {
                    $message->subject('eSurvey Verification');
                    $message->to($user->email);
                });
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

//        $this->dispatch(new SendActivationEmail($user));
        return redirect('verify')->with('status', 'Confirmation Email sent! Please check your inbox.');
    }

    public function changeEmail(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|unique:users'
        ]);

        $email = $_GET['email'];
        $activationCode = str_random(50);
        $user = $request->user();
        $user->update([
            'activation_code' => $activationCode,
            'email' => $email
        ]);
        Mail::send('emails.activation',
            [
                'code' => $activationCode,
                'id' => $user->id,
                'name' => $request->user()->first_name . ' ' . $user->last_name
            ], function ($message) use ($user) {
                $message->subject('eSurvey Verification');
                $message->to($user->email);
            });
        return redirect('verify')->with('status', 'Confirmation Email sent to your new Email!');
    }
}
