<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>eSurvey</title>

    <link rel="icon" href="{{ asset('public/images/icon.png') }}">

    <!-- Fonts -->
    <!-- Font Awesome 4.6.3 -->
    <link rel="stylesheet" href="{{ asset('public/plugins/font-awesome-4.6.3/css/font-awesome.min.css') }}">
    <!-- Lato Font -->
{{--<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">--}}

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
    <!-- Bar rating -->
    <link rel="stylesheet" href="{{ asset('public/plugins/jquery-bar-rating/themes/bars-square.css') }}">
    <!-- Star rating -->
    <link rel="stylesheet" href="{{ asset('public/plugins/jquery-bar-rating/themes/fontawesome-stars.css') }}">

    <!-- Styles -->
    <!-- Bootstrap 3.3.7-->
    <link rel="stylesheet" href="{{ asset('public/plugins/bootstrap-3.3.7/css/bootstrap.min.css') }}">
    <!-- Theme style -->


    <link rel="stylesheet" href="{{ asset('public/plugins/AdminLTE-2.3.5/dist/css/AdminLTE.min.css') }}">

    <link rel="stylesheet" href="{{ asset('public/css/sidebar.css') }}">

{{--<link rel="stylesheet" href="{{ asset('public/css/app-sidebar.css') }}">--}}

<!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('public/plugins/AdminLTE-2.3.5/dist/css/skins/skin-esurvey.css') }}">

{{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('public/css/main.css') }}">

    @yield('style')
</head>
<body id="app-layout" class="hold-transition skin-esurvey layout-top-nav">
<?php
$questionCount = 0;
foreach ($survey->pages as $page) {
    $questionCount += $page->questions->count();
}
?>

<div class="wrapper">
    <header class="main-header top-header">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">

                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                </div>

                <!-- Left Side Of Navbar -->
                <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                    @if (Auth::user())

                        <!-- Create Survey, Display in all pages -->
                            <li><a href="{{ url('/create') }}" id="create-survey" class="btn-facebook"><i
                                            class="fa fa-plus"></i> Create Survey</a></li>
                            <li><a href="{{ url('mysurveys') }}"><i class="fa fa-edit"></i> My Surveys</a></li>
                            <li><a href="{{ url('templates') }}"><i class="fa fa-list-alt"></i> Templates</a></li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                            class="fa fa-area-chart"></i> Reports <span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Summary</a></li>
                                    <li><a href="#">User Responses</a></li>
                                    <li><a href="#">Sources</a></li>
                                </ul>
                            </li>
                            @if(Auth::user()->role->title != "User")
                                <li><a href="{{ url('admin') }}"><i class="fa fa-user"></i> Admin Mode</a></li>
                            @endif
                        @endif
                    </ul>
                </div>

                <!-- Right Side Of Navbar -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else

                        <!-- User Account Menu -->
                            @include('common.user-menu')
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- content goes here -->
    <div class="content-wrapper with-sidebar">

        <div class="container">
            <div class="row content-row">
                <div class="col-sm-3 col-md-2 no-padding content-col">
                    <div class="slimScrollDiv sidebar"
                         style="position: relative; overflow: hidden; width: auto; height: 372px;">
                        <div class="sidebar" id="scrollspy" style="height: 372px; overflow: hidden; width: auto;">

                            <div class="text-center" style="margin-top:10px; margin-bottom: 10px;">
                                <a class="text-center" href="{{ url('mysurveys') }}">
                                    <img src="{{ asset('public/images/side-logo.png') }}" alt="logo"
                                         style="height:90px;">
                                </a>
                            </div>
                            <!-- sidebar menu: : style can be found in sidebar.less -->
                            <ul class="nav sidebar-menu">
                                <li class="text-center no-padding">
                                    <a href="{{ url('answer/'.$survey->id) }}"
                                       style="color: #169ef4;">esurvey/answer/{{ $survey->id }}</a>
                                </li>
                                <li>
                                    <span class="sidebar-info">Created</span>
                                    <span class="sidebar-number">{{ \Carbon\Carbon::parse($survey->created_at)->toFormattedDateString() }}</span>
                                </li>
                                <li>
                                    <span class="sidebar-info">Updated</span>
                                    <span class="sidebar-number">{{ \Carbon\Carbon::parse($survey->updated_at)->toFormattedDateString() }}</span>
                                </li>
                                <li>
                                    <span class="sidebar-info">Pages</span>
                                    <span class="sidebar-number">{{ $survey->pages()->count() }}</span>
                                </li>
                                <li>
                                    <span class="sidebar-info">Question</span>
                                    <span class="sidebar-number">{{ $questionCount }}</span>
                                </li>
                                <li>
                                    <span class="sidebar-info">Published</span>
                                    <span class="sidebar-number">{{ $survey->published ? "YES" : "NO" }}</span>
                                </li>
                                <li>
                                    <span class="sidebar-info">Status</span>
                                    <span class="sidebar-number">
                                    @if(!empty($option))
                                            {{ $option->open ? "Open" : "Close" }}
                                        @else
                                            Designing Mode
                                        @endif
                                    </span>
                                </li>
                                <li>
                                    <span class="sidebar-info">Multiple Responses</span>
                                    <span class="sidebar-number">
                                    @if(!empty($option))
                                            {{ $option->multiple_responses ? "YES" : "NO" }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li>
                                    <span class="sidebar-info">Date Close</span>
                                    <span class="sidebar-number">
                                    @if(!empty($option))
                                            {{ $option->data_close == null ? "None" : \Carbon\Carbon::parse($option->data_close)->toFormattedDateString() }}
                                        @else
                                            -
                                        @endif
                                    </span>
                                </li>
                                <li>
                                    <span class="sidebar-info">Responses</span>
                                    <span class="sidebar-number">{{ $respondents }}</span>
                                </li>
                                <li>
                                    <span class="sidebar-info">First Answer</span>
                                    <span class="sidebar-number">
                                         @if($respondents < 1)
                                            -
                                        @else
                                            {{ \Carbon\Carbon::parse($responses->sortBy('created_at')->first()->created_at)->toFormattedDateString() }}
                                        @endif
                            </span>
                                </li>
                                <li>
                                    <span class="sidebar-info">Last Answer</span>
                                    <span class="sidebar-number">
                                        @if($respondents < 1)
                                            -
                                        @else
                                            {{ \Carbon\Carbon::parse($responses->sortByDesc('created_at')->first()->created_at)->toFormattedDateString() }}
                                        @endif
                           </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 col-md-10 no-padding main-content content-col">

                    <section class="content-header">
                        <h1>{{ $survey->survey_title }}
                            <small>Dashboard</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                            <li><a href="{{ url('mysurveys') }}">My Surveys</a></li>
                            <li><a href="{{ url('survey/'.$survey->id) }}">{{ $survey->survey_title }}</a></li>
                        </ol>
                    </section>
                    <section class="content no-margin">
                        {{--<div class="row">--}}
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">
                                    <i class="fa fa-gears"></i> Actions
                                </h3>
                            </div>
                            <div class="box-body">
                                <div class="text-center">
                                    <div class="margin">
                                        <a href="{{ url('create/'.$survey->id) }}"
                                           class="btn btn-default btn-dashboard">
                                            <i class="fa {{ $survey->published ? 'fa-eye' : 'fa-pencil' }} fa-5x"></i>
                                            <br>
                                            {{ $survey->published ? 'Preview' : 'Edit' }}
                                        </a>
                                        <a href="{{ url('share/'.$survey->id) }}"
                                           class="btn btn-facebook btn-dashboard">
                                            <i class="fa fa-share-alt fa-5x"></i>
                                            <br>
                                            Share
                                        </a>

                                        <a href="{{ url('settings/'.$survey->id) }}"
                                           class="btn btn-warning btn-dashboard">
                                            <i class="fa fa-wrench fa-5x"></i>
                                            <br>
                                            Settings
                                        </a>
                                        <a href="{{ url('/analyze/' .$survey->id .'/result.pdf') }}" target="_blank"
                                           class="btn btn-danger btn-dashboard">
                                            <i class="fa fa-file-pdf-o fa-5x"></i>
                                            <br>
                                            Quick Report
                                        </a>
                                        <a href="{{ url('/analyze/' .$survey->id .'/summary') }}"
                                           class="btn btn-primary btn-dashboard">
                                            <i class="fa fa-pie-chart fa-5x"></i>
                                            <br>
                                            Analyze Summary
                                        </a>
                                        <a href="{{ url('/analyze/' .$survey->id .'/user') }}"
                                           class="btn btn-success btn-dashboard" style="margin-right: 0;">
                                            <i class="fa fa-users fa-5x"></i>
                                            <br>
                                            User Responses
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">
                                            Response Dates Statistics
                                        </h3>
                                    </div>
                                    <div class="box-body">
                                        <canvas id="dateChart" style="height: 255px; width: 510px;" height="255"
                                                width="510"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="box box-primary">
                                    <div class="box-header">
                                        <h3 class="box-title">
                                            Respondents Source Platform Statistics
                                        </h3>
                                    </div>
                                    <div class="box-body">
                                        <canvas id="platformChart" style="height: 255px; width: 510px;" height="255"
                                                width="510"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">
                                    Other
                                </h3>
                            </div>
                            <div class="box-body">
                                <div class="col-md-2 col-sm-3 col-xs-4">
                                    <button class="btn btn-primary btn-block btn-dashboard">
                                        <i class="fa fa-copy fa-5x"></i>
                                        <br>
                                        Copy Survey
                                    </button>
                                </div>
                                <div class="col-md-2 col-sm-3 col-xs-4">
                                    <form id="delete{{ $survey->id }}" method="POST"
                                          action="{{ url('/create/'.$survey->id) }}" class="delete-form">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button"
                                                class="btn btn-danger btn-block btn-dashboard  delete-survey"
                                                data-id="{{ $survey->id }}" data-toggle="tooltop"
                                                title="Delete this survey">
                                            <i class="fa fa-remove fa-5x"></i>
                                            <br>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

        <footer class="main-footer">
            <div class="container">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 0.1.2
                </div>
                <strong>Copyright &copy; 2016-2017 <a href="#">Fantastic Four</a>.</strong> All rights
                reserved.
            </div>
            <!-- /.container -->
        </footer>

    </div>

</div>

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

<!-- Miscellaneous -->
<!-- To Title Case -->
<script src="{{ asset('public/plugins/to-title-case/to-title-case.js') }}"></script>
<!-- BootBox 4.4.0-->
<script src="{{ asset('public/plugins/bootbox/bootbox.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('public/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- jQuery Toast -->
<script src="{{ asset('public/plugins/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
<!-- jQuery Toast Message -->
<script src="{{ asset('public/plugins/toast-plugin/jquery.toastmessage.js') }}"></script>
<!-- icheck -->
<script src="{{ asset('public/plugins/iCheck/icheck.min.js') }}"></script>
<!-- Moment -->
<script src="{{ asset('public/plugins/daterangepicker/moment.min.js') }}"></script>
<!-- DateRange Picker -->
<script src="{{ asset('public/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Barrating -->
<script src="{{ asset('public/plugins/jquery-bar-rating/jquery.barrating.min.js') }}"></script>

<!-- GLOBAL JS -->
<script src="{{ asset('public/js/global.js') }}"></script>


<?php
$barSources = \Illuminate\Support\Facades\DB::table('responses')
    ->select('source', 'survey_id', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
    ->groupBy('survey_id')
    ->get();


//INITIALIZE CHART DATAS
$colors = ["#f56954", "#00c0ef", "#f39c12", "#00a65a", "#3c8dbc"];
$pieData = [];
//$sources = $survey->responses->groupBy('source')->count();
$sources = \Illuminate\Support\Facades\DB::table('responses')
    ->select('source', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
    ->where('survey_id', $survey->id)
    ->groupBy('source')
    ->get();
$colorSelector = 0;
foreach ($sources as $source) {
    $pieData[] = array(
        "label" => $source->source,
        "value" => $source->total,
        "color" => $colors[$colorSelector++]
    );
}

?>
<script src="{{ asset('public/plugins/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('public/js/my-survey.js') }}"></script>
<script>
    $(function () {
        //-------------
        //- BAR CHART -
        //-------------
        var barChartCanvas = $("#dateChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var barChartData = {
            labels: <?php echo json_encode($barLabels) ?>,
            datasets: [
                {
                    label: "Total Respondents",
                    fillColor: "rgba(60,141,188,0.9)",
                    strokeColor: "rgba(60,141,188,0.8)",
                    pointColor: "#3b8bba",
                    pointStrokeColor: "rgba(60,141,188,1)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: <?php echo json_encode($barDatas) ?>
                }
            ]
        };
        console.log(barChartData);
//        barChartData.datasets[1].fillColor = "#00a65a";
//        barChartData.datasets[1].strokeColor = "#00a65a";
//        barChartData.datasets[1].pointColor = "#00a65a";
        var barChartOptions = {
            hovermode: "Total Respondents",
            //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
            scaleBeginAtZero: true,
            //Boolean - Whether grid lines are shown across the chart
            scaleShowGridLines: true,
            //String - Colour of the grid lines
            scaleGridLineColor: "rgba(0,0,0,.05)",
            //Number - Width of the grid lines
            scaleGridLineWidth: 1,
            //Boolean - Whether to show horizontal lines (except X axis)
            scaleShowHorizontalLines: true,
            //Boolean - Whether to show vertical lines (except Y axis)
            scaleShowVerticalLines: true,
            //Boolean - If there is a stroke on each bar
            barShowStroke: true,
            //Number - Pixel width of the bar stroke
            barStrokeWidth: 2,
            //Number - Spacing between each of the X value sets
            barValueSpacing: 5,
            //Number - Spacing between data sets within X values
            barDatasetSpacing: 1,
            tooltipTemplate: "<%if (label){%>Total Respondents: <%}%><%= value + ' ' %>",
<!--            multiTooltipTemplate: "Total Respondents : <%%= value %>",-->
            //String - A legend template
            legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);


        //-------------
        //- PIE CHART -
        //-------------
        // Get context with jQuery - using jQuery's .get() method.
        var pieChartCanvas = $("#platformChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = <?php echo json_encode($pieData) ?>;
        var pieOptions = {
            //Boolean - Whether we should show a stroke on each segment
            segmentShowStroke: true,
            //String - The colour of each segment stroke
            segmentStrokeColor: "#fff",
            //Number - The width of each segment stroke
            segmentStrokeWidth: 2,
            //Number - The percentage of the chart that we cut out of the middle
            percentageInnerCutout: 0, // This is 0 for Pie charts
            //Number - Amount of animation steps
            animationSteps: 100,
            //String - Animation easing effect
            animationEasing: "easeOutBounce",
            //Boolean - Whether we animate the rotation of the Doughnut
            animateRotate: true,
            //Boolean - Whether we animate scaling the Doughnut from the centre
            animateScale: false,
            //Boolean - whether to make the chart responsive to window resizing
            responsive: true,
            // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
            maintainAspectRatio: true,
            tooltipEvents: [],
            showTooltips: true,
            onAnimationComplete: function () {
                this.showTooltip(this.segments, true);
            },
            tooltipTemplate: "<%= label %> - <%= value %>"
                //String - A legend template
                {{--legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"--}}
            };
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            @if($respondents > 0)
            pieChart.Pie(PieData, pieOptions);
            @endif
        });
    </script>


<meta name="csrf-token" content="{{ csrf_token() }}">

</body>
</html>