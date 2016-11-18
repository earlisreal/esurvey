<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function sendMail(){
        return Mail::send('emails.activation',
            ['code' => str_random(50)], function($message){
            $message->subject('eSurvey Verification');
            $message->to('earl_savadera@yahoo.com');
        });

    }
}
