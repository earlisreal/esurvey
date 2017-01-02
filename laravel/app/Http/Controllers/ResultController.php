<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Question;
use App\QuestionChoice;
use App\QuestionType;
use App\Response;
use App\ResponseDetail;
use App\Survey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

use Illuminate\Support\Facades\DB;
use Log;
use Gate;

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
        if ($survey->published)
            return redirect('/analyze/' . $id . '/summary');
        else
            return view('misc.publish-first', ['survey' => $survey]);
    }

    public function summary($id, Request $request)
    {
        $survey = Survey::findOrFail($id);

        if (Gate::denies('manipulate-survey', $survey)) {
            abort(404);
        }

        if (!$survey->published) {
            return view('misc.publish-first', ['survey' => $survey]);
        }

        if ($survey->responses->count() < 1) { //Display no Response Message
            return view('misc.message', [
                'survey' => $survey
            ]);
        }



        $start = Carbon::parse($survey->responses->first()->created_at)->startOfDay();
        $end = Carbon::now()->endOfDay();
        if ($request->start != null && $request->end != null) {
            $start = Carbon::parse($request->start)->startOfDay();
            $end = Carbon::parse($request->end)->endOfDay();
        }

        $results = [];
        $totalResponse = $survey->responses()
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)->count();

        Log::info('Total Responses -> ' . $totalResponse);

        foreach ($survey->pages as $page) {
            foreach ($page->questions as $question) {
                $standardDeviation = 0;
                $average = 0;
                $variance = 0;
                $total = 0;
                $respondents = 0;
                $index = 0;
                $type = $question->questionType->type;
                $rows = [];
                $headers = [];
                $datas = [];
                switch ($type) {
                    case "Checkbox":
//                        $respondents = count(
//                            $question->responses()
//                                ->where('created_at', '>=', $start)
//                                ->where('created_at', '<=', $end)
//                                ->groupBy('response_id')
//                                ->get());
                    case "Multiple Choice":
                        foreach ($question->choices as $choice) {
                            $count = DB::table('response_details')
                                ->where('choice_id', $choice->id)
                                ->where('question_id', $question->id)
                                ->whereBetween('created_at', [$start, $end])
                                ->count();
                            $datas[] = array('id' => $choice->id, 'label' => $choice->label, 'data' => $count, 'color' => $this->colors[$index]);
                            $index++;
                            if ($type == "Multiple Choice")
                                $respondents += $count;
                            $total += $count;
                        }
                        break;
                    case "Textbox":
                    case "Text Area":
                        $responses = DB::table('response_details')
                            ->select(DB::raw('sentiment, COUNT(*) as sentiment_count'))
                            ->where('question_id', $question->id)
                            ->where('text_answer', '<>', 'NULL')
                            ->where('sentiment', '<>', 'NULL')
                            ->whereBetween('created_at', [$start, $end])
                            ->groupBy('sentiment')
                            ->get();
                        foreach ($responses as $response) {
                            $datas[] = array('label' => $response->sentiment, 'data' => $response->sentiment_count, 'color' => $this->colors[$index++]);
                            $index++;
                            $respondents += $response->sentiment_count;
                        }
                        break;
                    case "Rating Scale":
                        $maxRate = $question->option->max_rating;
                        $average = number_format($question->responses()->avg('text_answer'), 2);
                        for ($i = 1; $i <= $maxRate; $i++) {
                            $count = DB::table('response_details')
                                ->where('question_id', $question->id)
                                ->where('text_answer', $i)
                                ->whereBetween('created_at', [$start, $end])
                                ->count();

                            $datas[] = array('label' => $i, 'data' => $count, 'color' => $this->colors[$index]);
                            $index++;
                            $respondents += $count;
                            $variance += $count * pow(($i - $average), 2);
                        }
                        break;
                    case "Likert Scale":
                        foreach ($question->choices as $choice) {
                            $headers[] = $choice->label;
                        }
                        foreach ($question->rows as $row) {
                            $sum = 0;
                            $cols = [];
                            foreach ($question->choices as $choice) {
                                $count = DB::table('response_details')
                                    ->where('row_id', $row->id)
                                    ->where('choice_id', $choice->id)
                                    ->whereBetween('created_at', [$start, $end])
                                    ->count();
                                $cols[] = $count;
                                $total += $count;
                                $sum += $count * $choice->weight;
                            }
                            $count = $question->choices->count();
                            $rows[] = array('label' => $row->label, 'cols' => $cols,
                                'total' => $total, 'average' => number_format($sum / $count, 2));
                            $datas[] = array($row->label, number_format($sum / $count, 2));
                        }
                        break;
                }
                if ($respondents == 0) $respondents = 1;
                if ($type == "Checkbox" || $type == "Likert Scale") {
                    $respondents = count(
                        $question->responses()
                            ->where('created_at', '>=', $start)
                            ->where('created_at', '<=', $end)
                            ->where('choice_id', '<>', 'NULL')
                            ->groupBy('response_id')
                            ->get());
                } else {
                    $total = $respondents;
                }
                $results[] = array(
                    'datas' => $datas,
                    'questionTitle' => $question->question_title,
                    'total' => $total,
                    'grid' => array('rows' => $rows, 'headers' => $headers),
                    'type' => $type,
                    'respondents' => $respondents,
                    'average' => $average,
                    'standardDeviation' => number_format(sqrt($variance/($respondents)), 2)
                );
            }
        }

        Log::info($results);
        return view('survey.survey-summary', [
            'survey' => $survey,
            'results' => $results,
            'totalResponse' => $totalResponse
        ]);
    }

    public function user($id)
    {
        return view('survey.analyzeByUser', [
            'survey' => Survey::find($id)
        ]);
    }

    public function getDetails(Request $request, $id)
    {
        return view('modals.userResponse', [
            'response' => Response::find($request->response_id)
        ]);
    }

    public function generatePdf($id)
    {
        $survey = Survey::find($id);
        $filtered = false;
        $totalResponse = $survey->responses()->count();
        $start = "";
        $end = "";
        if (!empty($_GET['start']) && !empty($_GET['end'])) {
            $filtered = true;
            $start = $_GET['start'];
            $end = $_GET['end'];

            $totalResponse = $survey
                ->responses()
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end . ' 23:59:59')
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
