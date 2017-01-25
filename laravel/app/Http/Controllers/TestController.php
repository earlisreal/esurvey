<?php

namespace App\Http\Controllers;


use App\Jobs\SaveQuestionSpeech;
use App\Response;
use App\Survey;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\Promise;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Storage;
use Log;
use Psr\Http\Message\ResponseInterface;
use RobbieP\CloudConvertLaravel\Facades\CloudConvert;

class TestController extends Controller
{
    public function test(Request $request)
    {
//        $wav = Storage::disk('sound')->get('speech/question10.wav');
        CloudConvert::file(asset('public/sounds/speech/wav/question10.wav'))
            ->to(public_path('../public/sounds/speech/mp3/cloudtest.mp3'));
    }

    public function voice(Request $request)
    {
        $this->dispatch(new SaveQuestionSpeech(Survey::find(3)));
        $client = new Client();

        $promise = $client->requestAsync('GET', 'https://stream.watsonplatform.net/text-to-speech/api/v1/synthesize',
            [
                'auth' => [config('app.tts_username'), config('app.tts_password')],
                'headers' => ['Accept' => 'audio/wav'],
                'query' => [
                    'text' => "Hi I'm Earl is Real?"
                ]
            ]);
//        $response = $promise->tick();
//        Log::info($response);
        $promise->then(
            function (ResponseInterface $res) {
                Log::info("TTS RESPONSE -> " . $res->getStatusCode());
//                echo $res->getStatusCode() . "\n";
                if ($res->getStatusCode() == 200) {
                    Storage::disk('sound')->put('speech/question' . '12' . '.wav', $res->getBody());
                }
            },
            function (RequestException $e) {
                Log::info($e->getMessage());
                Log::info($e->getRequest()->getMethod());
            }
        );

        return 60;
//        Storage::disk('sound')->put('speech/result.wav', $res->getBody());
//        Log::info($res->getHeaders());
//        return $res->getBody();
    }

    public function input()
    {
        return view('test');
    }
}
