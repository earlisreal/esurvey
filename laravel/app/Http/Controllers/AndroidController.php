<?php

namespace App\Http\Controllers;

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

    public function create(Request $request){
        Log::info("earl from android");
        Log::info($request);
        return json_encode(User::all()->first());
    }

    public function register(Request $request){
//        $this->validate($request, [''])
        Log::info("log from Android");
        Log::info($request);
        $user = User::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),

        ]);
        Log::info($user);
        return json_encode($user);
    }

    public function login(Request $request){
//        Log::info($request);
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            return response()->json(User::where('username', $request->username)->first(), 200);
        }elseif(Auth::attempt(['email' => $request->username, 'password' => $request->password])){
            return response()->json(User::where('email', $request->username)->first(), 200);
        }else{
            return response(json_encode([]), 204);
        }

    }

    public function show($id){
        Log::info("earl is real here => " .$id);
        $surveys = User::find($id)
            ->surveys()->where('published', 1)->where('is_template', 0)->get();

        foreach ($surveys as $survey){
            $pages = $survey->pages;
            foreach ($pages as $page){
                $questions = $page->questions;
                foreach ($questions as $question){
                    if($question->questionType->has_choices){
                        $question->choices;
                    }
                    $question->rows;
                    $question->option;
                }
            }
        }

        Log::info(json_encode(array(
            "surveys" => $surveys
        )));
        return json_encode(array(
            "surveys" => $surveys,
            "survey_pages" => [],
            "questions" => [],
            "choices" => [],
            "rows" => []
        ));
    }

    public function store(Request $request){
        //STORING RESPONSE
        Log::info($request);
        $survey = Survey::find($request->survey_id);
        $option = $survey->option;
        if($option->open){
            if(empty($option->target_responses ) || $option->target_responses > $survey->responses->count()){
                $dt = Carbon::now();
                $dt->hour = 0;
                $dt->minute = 0;
                $dt->second = 0;

                if(empty($survey->option->date_close) || $dt->diffInDays(Carbon::parse($survey->option->date_close)) > 0){
//                    if(!$survey->option->multiple_responses && $survey->responses->where('source_ip',$request->ip())->count() > 0){
//                        return 4;
//                            //'message' => "You already Answered this Survey. Thank you!"
//                    }
                }else{
                    return 3;
                        //'message' => "The Survey is now Closed. Thank you for paying your time."
                }
            }else{
                return 2;
                    //'message' => "The Survey Has Reach its Target Responses. Thank you for paying your time."
            }
        }else{ //close
            return 1;
               // 'message' => $survey->option->closed_message
        }

        return DB::transaction(function () use ($request) {
            $survey = Survey::find($request->survey_id);
            $agent = new Agent();

            $response = new Response();
            $response->survey()->associate($survey);
            $response->source = "Android App";
            $response->source_ip = $request->ip();
            $response->created_at = $request->created_at;
            $response->save();

            foreach ($request->responseDetails as $responseDetail){
                $question = Question::find($responseDetail['question_id']);

                $detail = new ResponseDetail();
                $detail->response()->associate($response);
                $detail->question()->associate($question);



                if($question->questionType->has_choices){
                    if($responseDetail['choice_id'] != -1){
                        $detail->choice()->associate($responseDetail['choice_id']);
                    }
                }else{
                    $detail->text_answer = $responseDetail['text_answer'];
                }

                $detail->save();
            }

            return 0;
        });
    }



    public function downloadSpeech($id){
        return response()->download(base_path('../public/sounds/speech/question'.$id.'.wav'));
    }

}
