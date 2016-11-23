@extends($adminMode ? 'layouts.admin' : 'layouts.app-with-sidebar')

@if($adminMode)
@section('content-header')
    <section class="content-header">
        <h1>
            {{ $survey->survey_title }}
            <small>Template Summary</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Templates</li>
            <li class="active">Summary</li>
        </ol>
    </section>

@endsection

@else

    <?php
    $questionCount = 0;
    foreach ($survey->pages as $page) {
        $questionCount += $page->questions->count();
    }
    ?>
@endif

@section('content')
    <div class="row content-row">
        <div class="col-sm-3 col-md-2 no-padding content-col">
            <div class="slimScrollDiv sidebar"
                 style="position: relative; overflow: hidden; width: auto; height: 372px;">
                <div class="sidebar" id="scrollspy" style="height: 372px; overflow: hidden; width: auto;">

                    <div class="text-center" style="margin-top:10px; margin-bottom: 10px;">
                        <a class="text-center" href="{{ url('mysurveys') }}">
                            <img src="{{ asset('public/images/side-logo.png') }}" alt="logo" style="height:90px;">
                        </a>
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="nav sidebar-menu">
                        <li class="text-center no-padding">
                            <a href="/" style="color: #169ef4;">esurvey/answer/69</a>
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
                            <span class="sidebar-number">{{ $option->open ? "Open" : "Close" }}</span>
                        </li>
                        <li>
                            <span class="sidebar-info">Multiple Responses</span>
                            <span class="sidebar-number">{{ $option->multiple_responses ? "YES" : "NO" }}</span>
                        </li>
                        <li>
                            <span class="sidebar-info">Date Close</span>
                            <span class="sidebar-number">{{ $option->data_close == null ? "None" : \Carbon\Carbon::parse($option->data_close)->toFormattedDateString() }}</span>
                        </li>
                        <li>
                            <span class="sidebar-info">Responses</span>
                            <span class="sidebar-number">{{ $survey->responses->count() }}</span>
                        </li>
                        <li>
                            <span class="sidebar-info">First Answer</span>
                            <span class="sidebar-number">
                                {{ \Carbon\Carbon::parse($survey->responses->sortBy('created_at')->first()->created_at)->toFormattedDateString() }}
                            </span>
                        </li>
                        <li>
                            <span class="sidebar-info">Last Answer</span>
                            <span class="sidebar-number">
                                {{ \Carbon\Carbon::parse($survey->responses->sortByDesc('created_at')->first()->created_at)->toFormattedDateString() }}
                           </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-sm-9 col-md-10 no-padding main-content content-col">

            <section class="content-header">
                <h1>{{ $survey->survey_title }} <small>Dashboard</small></h1>
                <ol class="breadcrumb">
                    <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li><a href="{{ url('mysurveys') }}">My Surveys</a></li>
                    <li><a href="{{ url('survey/'.$survey->id) }}">{{ $survey->survey_title }}</a></li>
                </ol>
            </section>
            <section class="content">
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
                                <button class="btn btn-default btn-dashboard">
                                    <i class="fa fa-eye fa-5x"></i>
                                    <br>
                                    Preview
                                </button>
                                <button class="btn btn-facebook btn-dashboard">
                                    <i class="fa fa-share-alt fa-5x"></i>
                                    <br>
                                    Share
                                </button>

                                <button class="btn btn-warning btn-dashboard">
                                    <i class="fa fa-wrench fa-5x"></i>
                                    <br>
                                    Settings
                                </button>
                                <button class="btn btn-danger btn-dashboard">
                                    <i class="fa fa-file-pdf-o fa-5x"></i>
                                    <br>
                                    Quick Report
                                </button>
                                <button class="btn btn-primary btn-dashboard">
                                    <i class="fa fa-pie-chart fa-5x"></i>
                                    <br>
                                    Analyze Summary
                                </button>
                                <button class="btn btn-success btn-dashboard" style="margin-right: 0;">
                                    <i class="fa fa-users fa-5x"></i>
                                    <br>
                                    User Responses
                                </button>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">
                                    Respondents Compare to All Other Survey
                                </h3>
                            </div>
                            <div class="box-body">

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">
                                    Source Platform Statistics
                                </h3>
                            </div>
                            <div class="box-body">

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
                            <button class="btn btn-danger btn-block btn-dashboard">
                                <i class="fa fa-remove fa-5x"></i>
                                <br>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

                {{--</div>--}}
                {{--<div class="row">--}}
                    {{--<div class="col-lg-4">--}}
                        {{--<div class="box box-primary">--}}
                            {{--<div class="box-header">--}}
                                {{--<h3 class="box-title">Survey Summary</h3>--}}
                            {{--</div>--}}
                            {{--<div class="box-body">--}}
                                {{--<h4>{{ $survey->survey_title }}</h4>--}}
                                {{--<p>Created {{ $survey->created_at }}</p>--}}
                                {{--<hr>--}}


                                {{--<h4>Pages: {{ $survey->pages()->count() }}</h4>--}}

                                {{--<p>Questions: {{ $questionCount }}</p>--}}

                            {{--</div>--}}
                            {{--<div class="box-footer">--}}
                                {{--<td class="text-center"><a href="{{ url('/create/'.$survey->id) }}"--}}
                                                           {{--class="btn btn-primary">{!! $survey->published ? '<i class="fa fa-eye"></i> View' : '<i class="fa fa-pencil"></i> Edit' !!}</a>--}}
                                {{--</td>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="col-lg-8">--}}
                        {{--<div class="col-lg-6">--}}
                            {{--<div class="info-box">--}}
                                {{--<!-- Apply any bg-* class to to the icon to color it -->--}}
                                {{--<span class="info-box-icon bg-aqua"><i class="fa fa-share"></i></span>--}}
                                {{--<div class="info-box-content">--}}
                                    {{--<span class="info-box-text">published</span>--}}
                                    {{--<span class="info-box-number">{{ $survey->published ? 'Yes' : 'No' }}</span>--}}
                                {{--</div><!-- /.info-box-content -->--}}
                            {{--</div><!-- /.info-box -->--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6">--}}
                            {{--<div class="info-box">--}}
                                {{--<!-- Apply any bg-* class to to the icon to color it -->--}}
                                {{--<span class="info-box-icon bg-aqua-active"><i class="fa fa-check"></i></span>--}}
                                {{--<div class="info-box-content">--}}
                                    {{--<span class="info-box-text">Status</span>--}}
                                    {{--<span class="info-box-number">--}}
                            {{--@if($survey->published)--}}
                                            {{--{{ $survey->option->open ? 'Open' : 'Closed' }}--}}
                                        {{--@else--}}
                                            {{--Editing mode--}}
                                        {{--@endif--}}
                        {{--</span>--}}
                                {{--</div><!-- /.info-box-content -->--}}
                            {{--</div><!-- /.info-box -->--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6">--}}
                            {{--<div class="info-box">--}}
                                {{--<!-- Apply any bg-* class to to the icon to color it -->--}}
                                {{--<span class="info-box-icon bg-light-blue"><i class="fa fa-users"></i></span>--}}
                                {{--<div class="info-box-content">--}}
                                    {{--<span class="info-box-text">Responses</span>--}}
                                    {{--<span class="info-box-number">{{ $survey->responses->count() }}</span>--}}
                                {{--</div><!-- /.info-box-content -->--}}
                            {{--</div><!-- /.info-box -->--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6">--}}
                            {{--<div class="info-box">--}}
                                {{--<!-- Apply any bg-* class to to the icon to color it -->--}}
                                {{--<span class="info-box-icon bg-blue"><i class="fa fa-crosshairs"></i></span>--}}
                                {{--<div class="info-box-content">--}}
                                    {{--<span class="info-box-text">Target Responses</span>--}}
                                    {{--<span class="info-box-number">--}}
                            {{--<a href="{{ url('share/'.$survey->id) }}">--}}
                                {{--@if($survey->option != null)--}}
                                    {{--{{ $survey->option->target_responses == null ? 'None' : $survey->option->target_responses }}--}}
                                {{--@else--}}
                                    {{--None--}}
                                {{--@endif--}}

                            {{--</a>--}}
                        {{--</span>--}}
                                {{--</div><!-- /.info-box-content -->--}}
                            {{--</div><!-- /.info-box -->--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6">--}}
                            {{--<div class="info-box">--}}
                                {{--<!-- Apply any bg-* class to to the icon to color it -->--}}
                                {{--<span class="info-box-icon bg-light-blue"><i class="fa fa-calendar-times-o"></i></span>--}}
                                {{--<div class="info-box-content">--}}
                                    {{--<span class="info-box-text">Auto Close Date</span>--}}
                                    {{--<span class="info-box-number">--}}
                            {{--<a href="{{ url('share/'.$survey->id) }}">--}}
                                {{--@if($survey->option != null)--}}
                                    {{--{{ $survey->option->date_close == null ? 'None' : $survey->option->date_close }}--}}
                                {{--@else--}}
                                    {{--None--}}
                                {{--@endif--}}
                            {{--</a>--}}
                        {{--</span>--}}
                                {{--</div><!-- /.info-box-content -->--}}
                            {{--</div><!-- /.info-box -->--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6">--}}
                            {{--<div class="info-box">--}}
                                {{--<!-- Apply any bg-* class to to the icon to color it -->--}}
                                {{--<span class="info-box-icon bg-blue"><i class="fa fa-share-alt"></i></span>--}}
                                {{--<div class="info-box-content">--}}
                                    {{--<span class="info-box-text">Share</span>--}}
                                    {{--<span class="info-box-number"><a--}}
                                                {{--href="{{ url('share/'.$survey->id) }}">Share Survey</a></span>--}}
                                {{--</div><!-- /.info-box-content -->--}}
                            {{--</div><!-- /.info-box -->--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6">--}}
                            {{--<div class="info-box">--}}
                                {{--<!-- Apply any bg-* class to to the icon to color it -->--}}
                                {{--<span class="info-box-icon bg-blue"><i class="fa fa-pie-chart"></i></span>--}}
                                {{--<div class="info-box-content">--}}
                                    {{--<span class="info-box-text">Analyze</span>--}}
                                    {{--<span class="info-box-number"><a--}}
                                                {{--href="{{ url('analyze/'.$survey->id) }}">Summary</a></span>--}}
                                {{--</div><!-- /.info-box-content -->--}}
                            {{--</div><!-- /.info-box -->--}}
                        {{--</div>--}}
                        {{--<div class="col-lg-6">--}}
                            {{--<div class="info-box">--}}
                                {{--<!-- Apply any bg-* class to to the icon to color it -->--}}
                                {{--<span class="info-box-icon bg-blue"><i class="fa fa-comments"></i></span>--}}
                                {{--<div class="info-box-content">--}}
                                    {{--<span class="info-box-text">Analyze</span>--}}
                                    {{--<span class="info-box-number"><a href="{{ url('analyze/'.$survey->id .'/user') }}">User Responses</a></span>--}}
                                {{--</div><!-- /.info-box-content -->--}}
                            {{--</div><!-- /.info-box -->--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </section>
        </div>
    </div>
    <div class="col-lg-offset-1 col-lg-10">

    </div>



@endsection