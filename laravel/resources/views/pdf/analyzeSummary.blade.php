<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>eSurvey</title>
    <link rel="icon" href="{{ asset('public/images/pdf.ico') }}">

    <!-- Fonts -->
    <!-- Font Awesome 4.6.3 -->
    <link rel="stylesheet" href="{{ asset('public/plugins/font-awesome-4.6.3/css/font-awesome.min.css') }}">
    <!-- Lato Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">



    <!-- Miscs -->
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('public/plugins/ionicons-2.0.1/css/ionicons.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('public/plugins/datatables/dataTables.bootstrap.css') }}">
    <!-- jQuery Toast -->
    <link rel="stylesheet" href="{{ asset('public/plugins/jquery-toast-plugin/jquery.toast.min.css') }}">
    <!-- jQuery Toast -->
    <link rel="stylesheet" href="{{ asset('public/plugins/toast-plugin/jquery.toastmessage.css') }}">
    <!-- icheck -->
    <link rel="stylesheet" href="{{ asset('public/plugins/iCheck/all.css') }}">
    <!-- DateRange Picker -->
    <link rel="stylesheet" href="{{ asset('public/plugins/daterangepicker/daterangepicker.css') }}">



    <!-- Styles -->
    <!-- Bootstrap 3.3.7-->
    <link rel="stylesheet" href="{{ asset('public/plugins/bootstrap-3.3.7/css/bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/plugins/AdminLTE-2.3.5/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('public/plugins/AdminLTE-2.3.5/dist/css/skins/_all-skins.min.css') }}">

{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('public/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/pdf.css') }}">

    @yield('style')
</head>

<body>

<div class="row">
    <div class="col-xs-2">
        <img src="{{ asset('public/images/logo.png') }}" height="120px">
    </div>
    <div class="col-xs-10">
        <h1 class="text-center" style="margin-bottom: 0px;">
            <b>eSurvey</b>
        </h1>
        <h2 class="text-center" style="margin-top: 0px;margin-bottom: 0px">
            {{ $user->first_name ." " .$user->last_name .": " . $survey->survey_title }}
        </h2>
        <h3 class="text-center" style="margin-top: 0px;">
            Summary of {{ $survey->responses->count() }} Total Responses From
            {{ \Carbon\Carbon::parse($survey->responses()->orderBy('created_at')->first()->created_at)->toFormattedDateString() }}
            To
            {{ \Carbon\Carbon::parse($survey->responses()->orderBy('created_at', 'desc')->first()->created_at)->toFormattedDateString() }}
        </h3>
    </div>
</div>

<hr>

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
                        <div id="donut-holder" class="data-chart">
                            <div id="donut-chart{{ $questionNo }}" style="height: 300px; width: 800px"></div>
                            <label id="donut-data{{ $questionNo++ }}"
                                   style="position: relative; bottom: 200px; left: 47.25%;"></label>
                        </div>

                        <table class="table table-bordered">
                            <?php
                            $donutItem = [];
                            $colorSelector = 0;
                            $total = 0;
                            if($filtered) {
                                $responseNumber = DB::table('surveys')
                                        ->join('responses', 'surveys.id', '=', 'responses.survey_id')
                                        ->join('response_details', 'responses.id', '=', 'response_details.response_id')
                                        ->where('question_id', $question->id)
                                        ->where('responses.created_at', '>=', $start)
                                        ->where('responses.created_at', '<=', $end.' 23:59:59')
                                        ->count();
                            }else{
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
                                $max_rate = $question->option->max_rating ;
                                $average = number_format($responseDetails
                                        ->where('question_id' , $question->id)->avg('text_answer'),
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
                                            if($filtered){
                                                $count = $question
                                                        ->responses()
                                                        ->where('text_answer', $i)
                                                        ->where('created_at', '>=', $start)
                                                        ->where('created_at', '<=', $end.' 23:59:59')
                                                        ->groupBy('text_answer')
                                                        ->count();
                                            } else{
                                                $count = $question
                                                        ->responses()
                                                        ->where('text_answer', $i)
                                                        ->groupBy('text_answer')
                                                        ->count();
                                            }
                                            ?>
                                            {{ $count }}
                                        </td>
                                        <td>{{ number_format($count/$responseNumber*100, 2, '.', ',') }}%</td>
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
                                    Standard Deviation of <b>{{ number_format(sqrt($variance/($responseNumber)), 2, '.', ',') }}</b>
                                    - A standard deviation of small value means that the values, in a distribution are scattered or spread out near the mean and vice versa.
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
                                            if($filtered){
                                                $count = DB::table('surveys')
                                                        ->join('responses', 'surveys.id', '=', 'responses.survey_id')
                                                        ->join('response_details', 'responses.id', '=', 'response_details.response_id')
                                                        ->where('question_id', $question->id)
                                                        ->where('choice_id', $choice->id)
                                                        ->where('responses.created_at', '>=', $start)
                                                        ->where('responses.created_at', '<=', $end.' 23:59:59')
                                                        ->groupBy('choice_id')
                                                        ->count();
                                            }else{
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
                                        <td>{{ number_format($count/$responseNumber*100, 2, '.', ',') }}%</td>
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

<!-- jQuery 2.2.3 -->
<script src="{{ asset('public/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('public/plugins/bootstrap-3.3.7/js/bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('public/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('public/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/plugins/AdminLTE-2.3.5/dist/js/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/plugins/AdminLTE-2.3.5/dist/js/demo.js') }}"></script>


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
            for(i=1; i <= {{ $questionNo-1 }}; i++) {
//                    console.log(datas[i-1]);
//                $("#donut-data"+i).html("<h3 class='text-center'>" +averages[i-1] +"</h3><h4>Average</h4>");
                $.plot("#donut-chart"+i, datas[i-1], {
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
</body>
