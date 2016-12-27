<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Response;
use App\ResponseDetail;
use App\Survey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Jenssegers\Agent\Agent;
use Log;

class ResponseController extends Controller
{

    function __construct()
    {
        $this->middleware('answer:'.Route::current()->getParameter('id'));
    }

    public function index()
    {
        //
    }

    public function show($id, Request $request)
    {

        $survey = Survey::find($id);
        if (session('thankyou')) {
            return view('misc.close-message', [
                'message' => session('thankyou')
            ]);
        }

        if ($survey->published) {
            if ($survey->option->open) {
                if (empty($survey->option->target_responses) || $survey->option->target_responses > $survey->responses->count()) {
                    $dt = Carbon::now();
                    $dt->hour = 0;
                    $dt->minute = 0;
                    $dt->second = 0;

                    if (empty($survey->option->date_close) || $dt->diffInDays(Carbon::parse($survey->option->date_close)) > 0) {
                        $agent = new Agent();
                        if (!$survey->option->multiple_responses && $survey->responses->where('source_ip', $request->ip())->count() > 0) {
                            return view('misc.close-message', [
                                'message' => "You already Answered this Survey. Thank you!"
                            ]);
                        } else {
                            return view('survey.answer', [
                                'survey' => $survey,
                            ]);
                        }
                    } else {
                        return view('misc.close-message', [
                            'message' => "The Survey is now Closed. Thank you for paying your time."
                        ]);
                    }
                } else {
                    return view('misc.close-message', [
                        'message' => "The Survey Has Reach its Target Responses. Thank you for paying your time."
                    ]);
                }
            } else { //close
                return view('misc.close-message', [
                    'message' => $survey->option->closed_message
                ]);
            }
        }
    }

    public function store($id, Request $request)
    {
//        Log::info($request);
        $survey = Survey::find($id);
        $agent = new Agent();
        $test = array();
        $check = array();

        foreach ($survey->pages as $page) {
            foreach ($page->questions as $question) {
                if ($question->is_mandatory) {
                    if($question->questionType->type == "Likert Scale"){
                        foreach ($question->rows as $row){
                            $check['row' . $row->id] = 'required|min:1';
                        }
                        continue;
                    }
                    $check['question' . $question->id] = 'required|min:1';
                }
            }
        }

        $this->validate($request, $check);

        DB::transaction(function () use ($survey, $request, $test, $agent) {

            $response = new Response();
            $response->survey()->associate($survey);
            $response->source = $agent->platform();
            $response->source_ip = $request->ip();
            if($survey->option->register_required){
                $response->user()->associate(Auth::user());
            }
            $response->save();

            foreach ($survey->pages as $page) {
                foreach ($page->questions as $question) {
                    switch ($question->questionType->type) {
                        case "Checkbox":
                            if (count($request->input('question' . $question->id)) > 0) {
                                foreach ($request->input('question' . $question->id) as $item) {
//                                    Log::info("selected -> " . $item);
                                    $detail = new ResponseDetail();
                                    $detail->response()->associate($response);
                                    $detail->question()->associate($question);
                                    $detail->choice()->associate($item);
                                    $detail->save();
                                }
                            }
                            break;
                        case "Likert Scale":
                            foreach ($question->rows as $row){
//                                $response->responseDetails()->create([
//                                    'choice_id' => $request->input('row' .$row->id),
//                                    'question_id' => $question->id,
//                                ]);
                                $detail = new ResponseDetail();
                                $detail->choice()->associate($request->input('row' .$row->id));
                                $detail->question()->associate($question);
                                $detail->response()->associate($response);
                                $detail->row()->associate($row);
                                $detail->save();
                            }
                            break;
                        default:
                            $detail = new ResponseDetail();
                            $detail->response()->associate($response);
                            $detail->question()->associate($question);

                            if ($question->questionType->has_choices) {
                                $detail->choice()->associate($request->input('question' . $question->id));
                            } else {
                                $detail->text_answer = $request->input('question' . $question->id);
                            }

                            $detail->save();
                    }

                }
            }
        });
//        return view('survey.thankYou', [
//            'input' => $request->all(),
//            'test' => $test,
//        ]);

        return redirect('answer/' . $id)->with('thankyou', ($survey->option->response_message == null ? "Thank you for spending your time with us!" : $survey->option->response_message));
    }

}
