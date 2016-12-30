<?php

namespace App\Http\Controllers;


use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Storage;
use Log;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $client = new Client();

        $res = $client->get('https://gateway-a.watsonplatform.net/calls/text/TextGetTextSentiment',
            [
                'query' => [
                    'apikey' => config('alchemy_key'),
                    'text' => 'earl is good!',
                    'outputMode' => 'json'
                ]
            ]);
        Log::info($res->getBody());
        return $res->getBody();
    }

    public function voice(Request $request)
    {
        $client = new Client();

        $res = $client->get('https://stream.watsonplatform.net/text-to-speech/api/v1/synthesize',
            [
                'auth' => ['582e7a16-94ce-4726-b5cd-aac87da2f56c', 'EyFVRxJHaOKx'],
                'headers' => ['Accept' => 'audio/wav'],
                'query' => [
                    'text' => "Hi I'm Earl is Real?"
                ]
            ]);

        Storage::put('public/voice/result.wav', $res->getBody());
        Log::info($res->getHeaders());
        return $res->getBody();
    }

    public function input(){
        return view('test');
    }
}
