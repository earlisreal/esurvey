<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Question;
use App\QuestionType;
use App\Response;
use App\ResponseDetail;
use App\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

use Illuminate\Support\Facades\DB;
use Log;

class ResultController extends Controller
{

    private $colors = array(
        "#3c8dbc", "#0073b7", "#00c0ef", "#0099CC", "#50A6C2", "#39B7CD", "#00688B",
        "#0198E1", "#35586C", "#5CACEE", "#36648B", "#62B1F6", "#4E78A0", "#0D4F8B",
        "#23238E", "#3232CC", "#7171C6", "#7093DB", "#CAE1FF", "#B9D3EE", "#05B8CC",
        "#8EE5EE", "#C1F0F6", "#39B7CD", "#AFEEEE", "#37FDFC", "#00C5CD", "#B0E0E6",
        "#3c8dbc", "#0073b7", "#00c0ef", "#0099CC", "#50A6C2", "#39B7CD", "#00688B",
        "#0198E1", "#35586C", "#5CACEE", "#36648B", "#62B1F6", "#4E78A0", "#0D4F8B",
        "#23238E", "#3232CC", "#7171C6", "#7093DB", "#CAE1FF", "#B9D3EE", "#05B8CC",
        "#8EE5EE", "#C1F0F6", "#39B7CD", "#AFEEEE", "#37FDFC", "#00C5CD", "#B0E0E6",
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function show($id)
    {
        $survey = Survey::find($id);
        if($survey->published)
            return redirect('/analyze/' .$id .'/summary');
        else
            return view('misc.publish-first', ['survey' => $survey]);
    }

    public function summary($id){
        $survey = Survey::find($id);

        if($survey->published){
            if($survey->responses->count() > 0){
//            DB::table('questions')
//            ->where('questionType->hast_choices')
//            ->orWhere('questionType->type', 'Rating Scale')
//            ->get();
                return view('survey.survey-summary', [
                    'survey' => $survey,
                    'responseDetails' => ResponseDetail::all(),
                    'colors' => $this->colors
                ]);
            }else{
                return view('misc.message', [
                    'survey' => $survey
                ]);
            }
        }
        else{
            return view('misc.publish-first', ['survey' => $survey]);
        }

//
    }

    public function user($id){
        return view('survey.analyzeByUser', [
            'survey' => Survey::find($id)
        ]);
    }

    public function getDetails(Request $request, $id){
        return view('modals.userResponse', [
            'response' => Response::find($request->response_id)
        ]);
    }

    public function generatePdf($id){
        $survey = Survey::find($id);
        $filtered = false;
        $totalResponse = $survey->responses()->count();
        $start = "";
        $end = "";
        if(!empty($_GET['start']) && !empty($_GET['end'])){
            $filtered = true;
            $start = $_GET['start'];
            $end = $_GET['end'];

            $totalResponse = $survey
                ->responses()
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end.' 23:59:59')
                ->count();
        //            ->whereBetween('created_at', array($start, $end))->count();
        }


        $pdf = PDF::loadView('pdf.analyzeSummary', [
            'survey' => $survey,
            'colors' => $this->colors,
            'user' => Auth::user(),
            'filtered' => $filtered,
            'totalResponse' => $totalResponse,
            'responseDetails' => ResponseDetail::all(),
            'start' => $start,
            'end' => $end,
        ]);
        return $pdf->inline('result.pdf');
    }
}
