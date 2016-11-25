<?php
$filtered = false;
$totalResponse = $survey->responses()->count();
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

?>

@extends('layouts.app-with-sidebar')

@section('header')
    @include('common.header')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('public/css/analyze-summary.css') }}">
@endsection

@section('content-header')
    <section class="content-header">
        <h1>
            {{ $totalResponse }} Analyze {{ $survey->survey_title }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('mysurveys') }}">My Surveys</a></li>
            <li><a href="{{ url('survey/'.$survey->id) }}">{{ $survey->survey_title }}</a></li>
            <li class="active">Analyze</li>
        </ol>
    </section>
@endsection

@section('content')

    <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a href="{{ url('/analyze/' .$survey->id .'/summary') }}"
                                                  aria-controls="home" role="tab"><i class="fa fa-pie-chart"></i>
                Summary</a></li>
        <li role="presentation"><a href="{{ url('/analyze/' .$survey->id .'/user') }}" aria-controls="by-user"
                                   role="tab"><i class="fa fa-users"></i> User Responses</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active">
            <div class="row">
                <div class="col-xs-12">
                    {{--<h4>Earl is Real</h4>--}}
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label for="filter-btn" class="control-label">Filter:</label>
                            <div class="input-group">
                                <button id="filter-btn" class="btn btn-primary daterange-btn"><span
                                            class="fa fa-filter"> </span> <span id="current-filter"> None</span>
                                </button>
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <div class="pull-right">

                                <label for="to-pdf" class="control-label">Download/Print:</label>
                                <div class="input-group">
                                    <a id="to-pdf" href="{{ url('/analyze/' .$survey->id .'/result.pdf') }}"
                                       target="_blank" class="btn btn-danger"><span
                                                class="fa fa-file-pdf-o"></span><span> Generate Pdf</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($totalResponse > 0)
                        <?php
                        $questionNo = 1;
                        $averages = array();
                        $donutChart = array();
                        ?>
                        @foreach($survey->pages()->orderBy('page_no')->get() as $page)
                            {{--Page {{ $page->page_no }}--}}
                            @foreach($page->questions()->orderBy('order_no', 'asc')->get() as $question)
                                @if($question->questionType->has_choices || $question->questionType->type == "Rating Scale")
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3><b> Q{{ $questionNo }}  </b> {{ $question->question_title }}</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div id="donut-holder">
                                                <div id="donut-chart{{ $questionNo }}" style="height: 300px;"></div>
                                                <label id="donut-data{{ $questionNo++ }}"
                                                       style="position: relative; bottom: 200px; left: 47.25%;"></label>
                                            </div>

                                            <table class="table table-bordered datatable">
                                                <?php
                                                $donutItem = [];
                                                $colorSelector = 0;
                                                $total = 0;
                                                if ($filtered) {
                                                    $responseNumber = DB::table('surveys')
                                                            ->join('responses', 'surveys.id', '=', 'responses.survey_id')
                                                            ->join('response_details', 'responses.id', '=', 'response_details.response_id')
                                                            ->where('question_id', $question->id)
                                                            ->where('responses.created_at', '>=', $start)
                                                            ->where('responses.created_at', '<=', $end . ' 23:59:59')
                                                            ->count();
                                                } else {
                                                    $responseNumber = DB::table('surveys')
                                                            ->join('responses', 'surveys.id', '=', 'responses.survey_id')
                                                            ->join('response_details', 'responses.id', '=', 'response_details.response_id')
                                                            ->where('question_id', $question->id)
                                                            ->count();
                                                }

                                                ?>
                                                Out of {{ $totalResponse }} responses - {{ $responseNumber }} answered,
                                                {{ $totalResponse - $responseNumber }} skipped
                                                @if($question->questionType->type == "Rating Scale")
                                                    <?php
                                                    $max_rate = $question->option->max_rating;
                                                    $average = number_format($responseDetails
                                                            ->where('question_id', $question->id)->avg('text_answer'),
                                                            2, '.', ',');
                                                    $variance = 0;
                                                    ?>
                                                    <thead>
                                                    <tr>
                                                        <th>Rate</th>
                                                        <th>Responses</th>
                                                        <th>Percent</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @for($i=3; $i <= $max_rate; $i++)
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>
                                                                <?php
                                                                if ($filtered) {
                                                                    $count = $question
                                                                            ->responses()
                                                                            ->where('text_answer', $i)
                                                                            ->where('created_at', '>=', $start)
                                                                            ->where('created_at', '<=', $end . ' 23:59:59')
                                                                            ->groupBy('text_answer')
                                                                            ->count();
                                                                } else {
                                                                    $count = $question
                                                                            ->responses()
                                                                            ->where('text_answer', $i)
                                                                            ->groupBy('text_answer')
                                                                            ->count();
                                                                }
                                                                ?>
                                                                {{ $count }}
                                                            </td>
                                                            <td>{{ number_format($count/$responseNumber*100, 2, '.', ',') }}
                                                                %
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $donutItem[] = array(
                                                                "label" => $i,
                                                                "data" => $count,
                                                                "color" => $colors[$colorSelector++]
                                                        );

                                                        $variance += $count * pow(($i - $average), 2);
                                                        ?>
                                                    @endfor

                                                    <tr>
                                                        <th>Total</th>
                                                        <td><b>{{ $responseNumber }}</b></td>
                                                        <td><b>100%</b></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Average</th>
                                                        <td>
                                                            <b>
                                                                {{ $average }}
                                                            </b>
                                                        </td>
                                                        {{--<td><b>{{ $total/$responseNumber/$max_rate*100 }}%</b></td>--}}
                                                    </tr>
                                                    <td colspan="3">
                                                        Standard Deviation of
                                                        <b>{{ number_format(sqrt($variance/($responseNumber)), 2, '.', ',') }}</b>
                                                        - A standard deviation of small value means that the values, in
                                                        a distribution are scattered or spread out near the mean and
                                                        vice versa.
                                                    </td>
                                                    </tr>
                                                    </tbody>
                                                @else
                                                    <thead>
                                                    <tr>
                                                        <th>Choice</th>
                                                        <th>Response</th>
                                                        <th>Percent</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($question->choices as $choice)
                                                        <tr>
                                                            <td>{{ $choice->label }}</td>
                                                            <td>
                                                                <?php
                                                                if ($filtered) {
                                                                    $count = DB::table('surveys')
                                                                            ->join('responses', 'surveys.id', '=', 'responses.survey_id')
                                                                            ->join('response_details', 'responses.id', '=', 'response_details.response_id')
                                                                            ->where('question_id', $question->id)
                                                                            ->where('choice_id', $choice->id)
                                                                            ->where('responses.created_at', '>=', $start)
                                                                            ->where('responses.created_at', '<=', $end . ' 23:59:59')
                                                                            ->groupBy('choice_id')
                                                                            ->count();
                                                                } else {
                                                                    $count = DB::table('surveys')
                                                                            ->join('responses', 'surveys.id', '=', 'responses.survey_id')
                                                                            ->join('response_details', 'responses.id', '=', 'response_details.response_id')
                                                                            ->where('question_id', $question->id)
                                                                            ->where('choice_id', $choice->id)
                                                                            ->groupBy('choice_id')
                                                                            ->count();
                                                                }

                                                                echo $count;
                                                                ?>
                                                            </td>
                                                            <td>{{ number_format($count/$responseNumber*100, 2, '.', ',') }}
                                                                %
                                                            </td>
                                                        </tr>


                                                        {{--INITIALIZE JAVA SCRIPT FOR CHART--}}
                                                        <?php
                                                        $donutItem[] = array(
                                                                "label" => str_limit($choice->label, 12),
                                                                "data" => $count,
                                                                "color" => $colors[$colorSelector++]
                                                        );
                                                        ?>
                                                    @endforeach
                                                    <tr>
                                                        <th>Total</th>
                                                        <td><b>{{ $responseNumber }}</b></td>
                                                        <td><b>100%</b></td>
                                                    </tr>
                                                    <tr>
                                                    </tbody>
                                                @endif
                                                <?php $donutChart[] = $donutItem; ?>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    @else
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3>No Responses for this Date</h3>
                            </div>
                        </div>
                    @endif
                </div>


            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <!-- FLOT CHARTS -->
    <script src="{{ asset('public/plugins/flot/jquery.flot.min.js') }}"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="{{ asset('public/plugins/flot/jquery.flot.resize.min.js') }}"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="{{ asset('public/plugins/flot/jquery.flot.pie.min.js') }}"></script>
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="{{ asset('public/plugins/flot/jquery.flot.categories.min.js') }}"></script>

    <!-- Page script -->
    @if($totalResponse > 0)
        <script>
            $(function () {
                var datas = <?php echo json_encode($donutChart) ?>;
                var averages = {{ json_encode($averages) }}
                //            console.log(averages);
                //            console.log(datas);
                for (i = 1; i <= {{ $questionNo-1 }}; i++) {
//                    console.log(datas[i-1]);
//                $("#donut-data"+i).html("<h3 class='text-center'>" +averages[i-1] +"</h3><h4>Average</h4>");
                    $.plot("#donut-chart" + i, datas[i - 1], {
                        series: {
                            pie: {
                                innerRadius: 0.5,
                                show: true,
                                radius: 1,
                                label: {
                                    show: true,
                                    radius: 1,
                                    formatter: labelFormatter,
                                    background: {
                                        opacity: 0.5,
                                        color: '#000'
                                    }
                                }
                            }
                        },
                        legend: {
                            show: true
                        }
                    });
                }
            });

            function labelFormatter(label, series) {
                return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
                        + label
                        + "<br>"
                        + series.percent.toFixed(2) + "%</div>";
            }


        </script>

    @endif

    <script>

        var minDate = '{{ $survey->responses()->orderBy('created_at')->first()->created_at }}';
    </script>

    <!-- SCRIPT -->
    <script src="{{ asset('public/js/analyze-summary.js') }}"></script>


@endsection