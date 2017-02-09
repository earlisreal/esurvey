<?php

namespace App\Http\Controllers;

use App\Jobs\AnalyzeText;
use App\Question;
use App\Response;
use App\ResponseDetail;
use App\Survey;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use Auth;

use Jenssegers\Agent\Agent;
use Log;

class AndroidController extends Controller
{
    public function index()
    {
        return "Earl is Real";
    }

    public function create(Request $request)
    {
//        Log::info("earl from android");
//        Log::info($request);
        return json_encode(User::all()->first());
    }

    public function register(Request $request)
    {
//        $this->validate($request, [''])
//        Log::info("log from Android");
//        Log::info($request);
        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);
//        Log::info($user);
        return json_encode($user);
    }

    public function login(Request $request)
    {
//        Log::info($request);
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json(User::where('username', $request->username)->first(), 200);
        } elseif (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
            return response()->json(User::where('email', $request->username)->first(), 200);
        } else {
            return response(json_encode([]), 204);
        }

    }

    public function show($id)
    {
//        Log::info("earl is real here => " . $id);
        $surveys = User::find($id)
            ->surveys()
            ->where('published', 1)
            ->where('is_template', 0)
            ->whereHas('option', function ($query) {

                $query->where('open', 1);
            })
            ->get();

        foreach ($surveys as $survey) {
            $pages = $survey->pages;
            foreach ($pages as $page) {
                $questions = $page->questions;
                foreach ($questions as $question) {
                    if ($question->questionType->has_choices) {
                        $question->choices;
                    }
                    $question->rows;
                    $question->option;
                }
            }
        }

//        Log::info(json_encode(array(
//            "surveys" => $surveys
//        )));
        return json_encode(array(
            "surveys" => $surveys,
            "survey_pages" => [],
            "questions" => [],
            "choices" => [],
            "rows" => []
        ));
    }

    public function store(Request $request)
    {
        //STORING RESPONSE

        return DB::transaction(function () use ($request) {
            $survey = Survey::find($request->survey_id);
            $agent = new Agent();

            $response = new Response();
            $response->survey()->associate($survey);
            $response->source = "Android App";
            $response->source_ip = $request->ip();
            $response->created_at = $request->created_at;
            $response->save();

            foreach ($request->responseDetails as $responseDetail) {
                $question = Question::find($responseDetail['question_id']);

                $detail = new ResponseDetail();
                $detail->response()->associate($response);
                $detail->question()->associate($question);

                if ($question->questionType->type == "Likert Scale") {
                    if ($responseDetail['row_id'] > 0) {
                        $detail->row_id = $responseDetail['row_id'];
                    }
                }

                if ($question->questionType->has_choices) {
                    if ($responseDetail['choice_id'] > 0) {
                        $detail->choice()->associate($responseDetail['choice_id']);
                    }
                } else {
                    $detail->text_answer = $responseDetail['text_answer'];
                    if ($question->questionType->type == "Text Area") {
                        $this->dispatch(new AnalyzeText($detail));
                    }
                }

                $detail->save();
            }

            return 0;
        });
    }


    public function downloadSpeech($id)
    {
        return response()->download(base_path('../public/sounds/speech/mp3/question' . $id . '.mp3'));
    }

}
