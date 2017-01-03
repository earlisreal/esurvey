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

use Illuminate\Support\Facades\Cache;
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
//        Cache::flush();
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

        $datas = $this->getResults($survey, $request);

        return view('survey.survey-summary', [
            'survey' => $survey,
            'results' => $datas['results'],
            'totalResponse' => $datas['totalResponse'],
            'responseCount' => $datas['responseCount'],
            'filters' => $datas['filters']
        ]);
    }

    public function addFilter($id, Request $request)
    {
        $survey = Survey::findOrFail($id);
        $datas = $request->datas;
        switch ($request->type) {
            case "date":
                Cache::forever('date' . $id,
                    ['start' => $datas['start'], 'end' => $datas['end']]);
                break;
            case "question":
                $questions = [];
                if (Cache::has('question' . $id)) {
                    $datas = $request->datas;
                    $questions = Cache::get('question' . $id);
                }
                $questions[$datas['id']] = $datas['values'];
                Log::info("QUESTION FILTER TEST:");

                Cache::forever('question' . $id, $questions);
                Log::info(Cache::get('question' . $id));
                break;
            case "texts":

                break;
            case "user":

                break;
        }

        return view('ajax.analyzeSummary', $this->getResults($survey));
    }

    public function removeFilter($id, Request $request){
        $key = $request->key;
        if($key == "question"){
            $questions = Cache::get($key.$id);
            unset($questions[$request->id]);
            Cache::forever($key.$id, $questions);
        }else if($key == "date"){
            Cache::pull('date'.$id);
        }else if($key == "all"){
            Cache::pull('question'.$id);
            Cache::pull('date'.$id);
        }

        return view('ajax.analyzeSummary', $this->getResults(Survey::find($id)));
    }

    private function getFilters($id)
    {
        $filters = array(
            'date' => [],
            'question' => [],
            'rows' => array(),
            'user' => array(),
        );
//        if(Cache::has('question'.$id)){
        $filters['question'] = Cache::get('question' . $id);
//        }

        Log::info(Cache::get('question' . $id));

        if (Cache::has(['date' . $id])) {
            $filters['date'] = Cache::get('date' . $id);
            Log::info($filters['date']);
        }

        return $filters;
    }

    private function getResults(Survey $survey)
    {


        /***************************************************************************************************************
         *                              RESULT MANIPULATION START HERE                                                 *
         **************************************************************************************************************/

        $filters = $this->getFilters($survey->id);

        Log::info($filters);

        $start = $survey->responses->sortBy('created_at')->first()->created_at;
        $end = Carbon::parse($survey->responses->sortByDesc('created_at')->first()->created_at)->endOfDay();

        $dates = $filters['date'];
        if (!empty($dates)) {
            $start = Carbon::parse($dates['start'])->startOfDay();
            $end = Carbon::parse($dates['end'])->endOfDay();
        }

        $responses = $survey->responses()
            ->select('id')
            ->where(function ($base) use ($filters, $survey) {
                if (!empty($filters['question'])) {
                    $questions = $filters['question'];
                    if (count($questions) > 0) {
                        Log::info("QUESTION READ");
                        Log::info($questions);
                        $base->whereHas('responseDetails', function ($query) use ($questions) {
                            foreach ($questions as $id => $values) {
                                Log::info("ID -> " . $id);
                                Log::info($values);
                                $query->where('question_id', $id);
                                if (Question::find($id)->questionType->type != "Rating Scale") {
                                    $query->whereIn('choice_id', $values);
                                } else {
                                    $query->whereIn('text_answer', $values);
                                }
                            }
                        });
                    }
                }

                if (!empty($filters['rows'])) {
                    //LIKERT SCALE
                    $base->whereHas('responseDetails', function ($query) use ($filters) {
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
                    });
                }

                if (!empty($filters['user'])) {
                    $base->whereHas('user', function ($subQuery) use ($filters) { //FILTER USER INFO
                        foreach ($filters['user'] as $field => $values) {
                            $subQuery->where(function ($query) use ($field, $values) {
                                foreach ($values as $value) {
                                    $query->orWhere($field, $value);
                                }
                            });
                        }
                    });
                }
            })
            //FILTER DATES
//            ->where('created_at', '>=', $start)
//            ->where('created_at', '<=', $end)

            ->whereBetween('created_at', [$start, $end])
            ->pluck('id');

//        return var_dump($responses);
//        Log::info($responses);

        $results = [];
        $responseCount = $survey->responses()->count();
        $totalResponse = $responses->count();

//        Log::info("COUNT -> " . $totalResponse);

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
                                ->whereIn('response_id', $responses)
                                ->where('choice_id', $choice->id)
                                ->where('question_id', $question->id)
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
                        $details = DB::table('response_details')
                            ->whereIn('response_id', $responses)
                            ->select(DB::raw('sentiment, COUNT(*) as sentiment_count'))
                            ->where('question_id', $question->id)
                            ->where('text_answer', '<>', 'NULL')
                            ->where('sentiment', '<>', 'NULL')
                            ->groupBy('sentiment')
                            ->get();
                        foreach ($details as $detail) {
                            $datas[] = array('label' => $detail->sentiment, 'data' => $detail->sentiment_count, 'color' => $this->colors[$index++]);
                            $index++;
                            $respondents += $detail->sentiment_count;
                        }
                        break;
                    case "Rating Scale":
                        $maxRate = $question->option->max_rating;
                        $average = number_format(
                            DB::table('response_details')
                                ->whereIn('response_id', $responses)
                                ->where('question_id', $question->id)
                                ->avg('text_answer'), 2);
                        for ($i = 1; $i <= $maxRate; $i++) {
                            $count = DB::table('response_details')
                                ->whereIn('response_id', $responses)
                                ->where('question_id', $question->id)
                                ->where('text_answer', $i)
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
                            $total = 0;
                            $cols = [];
                            foreach ($question->choices as $choice) {
                                $count = DB::table('response_details')
                                    ->whereIn('response_id', $responses)
                                    ->where('row_id', $row->id)
                                    ->where('choice_id', $choice->id)
                                    ->count();
                                $cols[] = $count;
                                $total += $count;
                                $sum += $count * $choice->weight;
                            }
                            $count = $question->choices->count();
                            $average = $total > 0 ? number_format($sum / $total, 2) : 0;
                            $rows[] = array('label' => $row->label, 'cols' => $cols,
                                'total' => $total, 'average' => $average);
                            $datas[] = array($row->label, $average);
                        }
                        break;
                }
                if ($type == "Checkbox" || $type == "Likert Scale") {
                    $respondents = count(
                        DB::table('response_details')
                            ->whereIn('response_id', $responses)
                            ->where('question_id', $question->id)
                            ->where('choice_id', '<>', 'NULL')
                            ->groupBy('response_id')
                            ->get());
                } else {
                    $total = $respondents;
                }
                $results[] = array(
                    'id' => $question->id,
                    'datas' => $datas,
                    'questionTitle' => $question->question_title,
                    'total' => $total,
                    'grid' => array('rows' => $rows, 'headers' => $headers),
                    'type' => $type,
                    'respondents' => $respondents,
                    'average' => $average,
                    'standardDeviation' => $total > 0 ? number_format(sqrt($variance / ($total)), 2) : 0
                );
            }
        }

//        Log::info($results);

        return array(
            'filters' => $filters,
            'results' => $results,
            'totalResponse' => $totalResponse,
            'responseCount' => $responseCount
        );
    }

    public function user($id)
    {
        return view('survey.analyzeByUser', [
            'survey' => Survey::find($id)
        ]);
    }

    public function getDetails(Request $request, $id)
    {
//        Log::info("ID -> " .$request->response_id);
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
