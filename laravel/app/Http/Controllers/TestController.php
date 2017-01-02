<?php

namespace App\Http\Controllers;


use App\Response;
use App\Survey;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Storage;
use Log;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $filters = array();


        $start = "";
        $end = "";
        $filters = array(['field' => 'choice_id', 'value' => 26]);


        $filters = array(
            'choices' => [27, 26, 28],
            'texts' => array('13' => ['1', '2']),
            'rows' => array('id' => [35, 36]),
            'user' => array('country' => 'PH', 'gender' => 'Male')
        );



        $responses = Survey::find(2)->responses()
            ->whereHas('responseDetails', function ($query) {
                //SHORTER WAY - MULTIPLE OR ON SAME QUESTION
                $query->orWhere('choice_id', 'like', 27);
                $query->orWhere('choice_id', 'like', 26);
                $query->orWhere('choice_id', 'like', 28);
            })
            //TEXT ANSWER / RATING SCALE
            ->whereHas('responseDetails', function ($subQuery) {
                $subQuery->where(function ($query) {
                    $query->where('question_id', '=', '13');
                    $query->where(function ($q) {
                        $q->where('text_answer', '=', '1');

                        $q->orWhere('text_answer', '=', '2');
                    });
                });

                $subQuery->where(function ($query) {
                    $query->where('question_id', '=', '11');
                    $query->where(function ($q) {
                        $q->where('text_answer', '=', 'holiday');
                    });
                });
            })
            //LIKERT SCALE
            ->whereHas('responseDetails', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('row_id', 16);
                    $subQuery->where(function ($q) {
                        $q->orWhere('choice_id', 35);
                        $q->orWhere('choice_id', 36);

                    });
                });

                $query->where(function ($subQuery) {
                    $subQuery->where('row_id', 15);
                    $subQuery->where(function ($q) {
                        $q->orWhere('choice_id', 35);
                        $q->orWhere('choice_id', 36);

                    });
                });
            })
            ->where(function ($subQuery) { //FILTER USER INFO
                $subQuery->whereHas('user', function ($query) {
                    $query->where('country', '=', 'PH');
                });
            })
            //FILTER DATES
//            ->where('created_at', '>=', $start)
//            ->where('created_at', '<=', $end)
            ->when(!empty($start) && !empty($end), function ($query) use ($start, $end) {
                $query
                    ->whereBetween('created_at', [$start, $end]);
            })
            //WHERE Date

            ->toSql();

//        $responses = Survey::find(2)->responses()
//            ->whereHas('responseDetails', function ($query) { //FILTER QUESTIONS
//                //SHORTER WAY - MULTIPLE OR ON SAME QUESTION
//                $query->orWhere('choice_id', 'like', 27)
//                    ->orWhere('choice_id', 'like', 26);
//            })
//            ->where(function ($subQuery) {
//                $subQuery->whereHas('responseDetails', function ($query) {
//                    $query->where('question_id', '=', '13');
//                });
//                $subQuery->whereHas('responseDetails', function ($query) {
//                    $query->where('text_answer', '=', '1');
//
//                    $query->orWhere('text_answer', '=', '2');
//                });
//            })
//            ->where(function ($subQuery){ //FILTER USER INFO
//                $subQuery->whereHas('user', function ($query){
//                   $query->where('country', '=', 'PH');
//                });
//            })
//            ->where('created_at', '>=', $start) //FILTER DATES
//            ->where('created_at', '<=', $end)
//            ->get();
        return ($responses);
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

    public function input()
    {
        return view('test');
    }
}
