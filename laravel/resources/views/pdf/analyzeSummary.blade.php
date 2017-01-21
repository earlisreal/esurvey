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
    <div class="col-xs-8">
        <h1 class="text-center" style="margin-bottom: 0px;">
            <b>eSurvey</b>
        </h1>
        <h2 class="text-center" style="margin-top: 0px;margin-bottom: 0px">
            Survey Title: {{ $survey->survey_title }}
        </h2>
        <h3 class="text-center" style="margin-top: 0px;">
            Created by: {{ $user->first_name ." " .$user->last_name }}
        </h3>
    </div>
</div>

<hr>


@if($totalResponse > 0)
    <?php
    $questionNo = 1;
    ?>

    @if(!empty($filters['date']) || !empty($filters['question']))
        <div class="row">
            <div class="col-xs-5">
                <h4>Filters:</h4>
                @if(!empty($filters['date']))
                    <h5>
                        <b>Date: </b>
                        {{ $filters['date']['start'] }} to {{ $filters['date']['end'] }}
                    </h5>
                @endif
                @if(!empty($filters['question']))
                    @foreach($filters['question'] as $id => $values)

                        <?php $question = \App\Question::find($id); ?>
                        @if($question->questionType->type == "Likert Scale")

                            @foreach($values as $key => $value)
                                <h5>
                                    <b>{{ $question->question_title }}: </b>
                                    {{ \App\QuestionRow::find($key)->label }} :
                                    @foreach($value as $choice)
                                        {{ \App\QuestionChoice::find($choice)->label }},
                                    @endforeach
                                </h5>

                            @endforeach
                        @else
                            <h5>
                                <b>{{ $question->question_title }}: </b>
                                @foreach($values as $value)
                                    {{ \App\QuestionChoice::find($value)->label }},
                                @endforeach
                            </h5>
                        @endif

                    @endforeach
                @endif
            </div>
        </div>
    @endif

    <h3>Respondents: {{ $totalResponse }} of {{ $responseCount }}</h3>

    @foreach($results as $result)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3><b> Q{{ $questionNo }}  </b> {{ $result['questionTitle'] }}</h3>
            </div>
            <div class="panel-body">

                @if($result['type'] == "Likert Scale")
                    <?php $grid = $result['grid'] ?>
                    <div class="data-chart" id="chart{{ $questionNo }}" style="height: 300px;  width: 900px"></div>
                    <table class="table">
                        Out of {{ $totalResponse }} responses - {{ $result['respondents'] }}
                        answered,
                        {{ $totalResponse - $result['respondents'] }} skipped
                        <thead>
                        <tr>
                            <th></th>
                            @foreach($grid['headers'] as $header)
                                <th>{{ $header['label'] }}</th>
                            @endforeach
                            <th>Total</th>
                            <th>Average</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($grid['rows'] as $row)
                            <tr>
                                <th>{{ $row['label'] }}</th>
                                @foreach($row['cols'] as $col)
                                    <td>{{ $col }}</td>
                                @endforeach
                                <td><b>{{ $row['total'] }}</b></td>
                                <td><b>{{ $row['average'] }}</b></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div id="chart-holder" class="data-chart">
                        <div id="chart{{ $questionNo }}" style="height: 300px; width: 900px"></div>
                        <label id="chart-data{{ $questionNo }}"
                               style="position: relative; bottom: 200px; left: 47.25%;"></label>
                    </div>
                    <table class="table table-bordered datatable">
                        Out of {{ $totalResponse }} responses - {{ $result['respondents'] }}
                        answered,
                        {{ $totalResponse - $result['respondents'] }} skipped

                        <thead>
                        <tr>
                            <th>Choice Label</th>
                            <th>Responses</th>
                            <th>Percentage</th>
                        </tr>
                        </thead>
                        @foreach($result['datas'] as $data)
                            <tr>
                                <td>{{ $data['label'] }}</td>
                                <td>{{ $data['data'] }}</td>
                                <td>{{ $result['total'] > 0 ? number_format($data['data'] / $result['total'] * 100, 2, '.', ',') : 0 }}
                                    %
                                </td>
                            </tr>
                        @endforeach
                        <tfoot>
                        <tr>
                            <th>Total</th>
                            <th>{{ $result['total'] }}</th>
                            <th>{{ $result['total'] > 0 ? 100 : 0 }}%</th>
                        </tr>
                        @if($result['type'] == "Rating Scale")
                            <tr>
                                <th>Average</th>
                                <td colspan="2">{{ $result['average'] }}</td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    Standard Deviation of
                                    <b>{{ $result['standardDeviation'] }}</b>
                                    - A standard deviation of small value means that the values, in
                                    a distribution are scattered or spread out near the mean and
                                    vice versa.
                                </td>
                            </tr>
                        @endif
                        </tfoot>
                    </table>
                @endif
            </div>
        </div>
        <?php $questionNo++ ?>
    @endforeach
@else
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>No Responses Found</h3>
        </div>
    </div>
@endif

Date Printed: {{ \Carbon\Carbon::now()->toDateTimeString() }}

<!-- jQuery 2.2.3 -->
<script src="{{ asset('public/plugins/jquery/jquery-2.2.3.min.js') }}"></script>
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

<script>
    var results = <?php echo json_encode($results) ?>;
</script>

<!-- SCRIPT -->
<script src="{{ asset('public/js/analyze-summary.js') }}"></script>
</body>
