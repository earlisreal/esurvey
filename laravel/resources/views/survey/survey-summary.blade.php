@extends('layouts.app-with-sidebar')

@section('header')
    @include('common.header')
@endsection

@section('style')
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('public/plugins/datepicker/datepicker3.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/analyze-summary.css') }}">
    <style>
        .legendLabel {
            font-size: 18px;
        }
    </style>
@endsection

@section('content-header')
    <section class="content-header">
        <h1>
            {{ $survey->survey_title }} Statistics
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
    <div class="tab-content" style="margin-top: 10px;">
        <div role="tabpanel" class="tab-pane active">
            <div class="row">
                <div class="col-xs-12">
                    {{--<h4>Earl is Real</h4>--}}
                    <div class="row">
                        <div class="form-group col-xs-3">
                            <label for="filter-btn" class="control-label">Filter:</label>
                            <div class="input-group">
                                <button id="filter-btn" class="btn btn-primary"><span
                                            class="fa fa-plus"> </span> <span id="current-filter"> Filter</span>
                                </button>
                                <div class="dropdown-menu filter-dropdown" style="min-width: 200px;">
                                    <div class="ranges">
                                        <ul>
                                            <li data-filter="date">Filter by Date</li>
                                            <li data-filter="question">Filter by Question Answer</li>
                                            <li data-filter="user">Filter by User Information</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="dropdown-menu date-filter dropdown-content" style="min-width: 320px;">
                                    <label for="">Filter Date</label>
                                    <div class="form-group">

                                        <input type="text" id="start-date" placeholder="Start Date">
                                        to
                                        <input type="text" id="end-date" placeholder="End Date">
                                    </div>

                                    <div class="range_inputs">
                                        <button class="applyBtn btn btn-sm btn-success" type="button">Apply</button>
                                        <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel
                                        </button>
                                    </div>
                                </div>

                                <div class="dropdown-menu question-filter dropdown-content" style="min-width: 320px;">
                                    <label for="">Question answer</label>

                                    <select name="question" id="question-select" class="form-control"
                                            style="margin-bottom: 10px">
                                    </select>

                                    <div class="range_inputs">
                                        <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel
                                        </button>
                                    </div>
                                </div>

                                <div class="dropdown-menu choices-filter dropdown-content" style="min-width: 320px;">
                                    <label id="question-label">Question Choices</label>

                                    <form action="" id="question-choices">

                                    </form>

                                    <div class="range_inputs">
                                        <button class="applyBtn btn btn-sm btn-success" type="button">Apply</button>
                                        <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-xs-6">
                            <h4>DAte</h4>
                            <h4>Question</h4>
                        </div>
                        <div class="form-group col-xs-3">
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

                    <h3>Respondents: {{ $totalResponse }} of {{ $totalResponse }}</h3>

                    @if($totalResponse > 0)
                        <?php
                        $questionNo = 1;
                        ?>
                        @foreach($results as $result)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3><b> Q{{ $questionNo }}  </b> {{ $result['questionTitle'] }}</h3>
                                </div>
                                <div class="panel-body">

                                    @if($result['type'] == "Likert Scale")
                                        <?php $grid = $result['grid'] ?>
                                        <div id="chart{{ $questionNo }}" style="height: 300px;  "></div>
                                        <table class="table dataable">
                                            Out of {{ $totalResponse }} responses - {{ $result['respondents'] }}
                                            answered,
                                            {{ $totalResponse - $result['respondents'] }} skipped
                                            <thead>
                                            <tr>
                                                <th></th>
                                                @foreach($grid['headers'] as $header)
                                                    <th>{{ $header }}</th>
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
                                        <div id="chart-holder">
                                            <div id="chart{{ $questionNo }}" style="height: 300px;"></div>
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
                                                    <td>{{ number_format($data['data'] / $result['respondents'] * 100, 2, '.', ',') }}
                                                        %
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tfoot>
                                            <tr>
                                                <th>Total</th>
                                                <th>{{ $result['total'] }}</th>
                                                <th>100%</th>
                                            </tr>
                                            @if($result['type'] == "Rating Scale")
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
    <script src="{{ asset('public/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
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
        for (var i = 1; i <= results.length; i++) {
            var data = results[i - 1]['datas'];
            if (results[i - 1]['type'] == 'Likert Scale') {
                console.log("earl is real");
                var bar_data = {
                    data: data,
                    color: "#3c8dbc"
                };
                barChart('#chart' + i, [bar_data]);
            } else {
                donutChart('#chart' + i, data);
            }
        }

        function donutChart(context, data) {
            $.plot(context, data, {
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

        function barChart(context, data) {
            $.plot(context, data, {
                grid: {
                    borderWidth: 1,
                    borderColor: "#f3f3f3",
                    tickColor: "#f3f3f3"
                },
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.5,
                        align: "center",
                        horizontal: false
                    }
                },
                xaxis: {
                    label: "choices",
                    mode: "categories",
                    tickLength: 0
                }
            });
        }

        function labelFormatter(label, series) {
            return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
                + label
                + "<br>"
                + series.percent.toFixed(2) + "%</div>";
        }

    </script>

    <!-- SCRIPT -->
    <script src="{{ asset('public/js/analyze-summary.js') }}"></script>


@endsection