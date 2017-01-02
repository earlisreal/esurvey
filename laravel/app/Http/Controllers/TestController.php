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
        $start = "";
        $end = "";

        $filters = array(
            'choices' => [27, 26, 28],
            'texts' => array('13' => ['1', '2']),
            'rows' => array('id' => [35, 36]),
            'user' => array('country' => ['PH', 'UK'], 'gender' => ['Male'])
        );


        $responses = Survey::find(2)->responses()
            ->whereHas('responseDetails', function ($query) use ($filters) {
                foreach ($filters['choices'] as $choice) {
                    $query->orWhere('choice_id', $choice);
                }
            })
            //TEXT ANSWER / RATING SCALE
            ->whereHas('responseDetails', function ($subQuery) use ($filters) {
                foreach ($filters['texts'] as $id => $texts) {
                    $subQuery->where(function ($query) use ($id, $texts) {
                        $query->where('question_id', $id);
                        $query->where(function ($q) use ($texts) {
                            foreach ($texts as $text) {
                                $q->orWhere('text_answer', $text);
                            }
                        });
                    });
                }
            })
            //LIKERT SCALE
            ->whereHas('responseDetails', function ($query) use ($filters) {
                foreach ($filters['rows'] as $id => $choices) {
                    $query->where(function ($subQuery) use ($id, $choices) {
                        $subQuery->where('row_id', $id);
                        $subQuery->where(function ($q) use ($choices) {
                            foreach ($choices as $choice) {
                                $q->orWhere('choice_id', $choice);
                            }
                        });
                    });
                }
            })
            ->whereHas('user', function ($subQuery) use ($filters) { //FILTER USER INFO
                foreach ($filters['user'] as $field => $values) {
                    $subQuery->where(function ($query) use ($field, $values) {
                        foreach ($values as $value) {
                            $query->orWhere($field, $value);
                        }
                    });
                }
            })
            //FILTER DATES
//            ->where('created_at', '>=', $start)
//            ->where('created_at', '<=', $end)
            ->when(!empty($start) && !empty($end), function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            })
            ->toSql();
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
