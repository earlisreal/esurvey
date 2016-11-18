<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class PublicController extends Controller
{
    public function activateUser($id, $code){
        $user = User::findOrFail($id);
        if(!$user->verified){
            if($user->activation_code === $code){
                $user->update(['verified' => true]);
                $message = 'Congratulations! Your Account is now Activated';
            }else{
                $message = "This link is expired or invalid. login to your account to send confirmation link to your email.";
            }
        }else{
            $message = "Your Account is already Activated";
        }

        return view('misc.random-message', ['message' => $message]);
    }
}
