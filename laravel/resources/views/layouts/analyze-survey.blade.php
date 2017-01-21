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
            Analyze {{ $survey->survey_title }}
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

    <ul class="nav nav-tabs no-print">
        <li role="presentation" class="{{ Request::is('analyze/'.$survey->id.'/summary') ? 'active' : '' }}"><a href="{{ url('/analyze/' .$survey->id .'/summary') }}"
                                                  aria-controls="home" role="tab"><i class="fa fa-pie-chart"></i>
                Summary</a></li>
        <li role="presentation" class="{{ Request::is('analyze/'.$survey->id.'/user') ? 'active' : '' }}"><a href="{{ url('/analyze/' .$survey->id .'/user') }}" aria-controls="by-user"
                                   role="tab"><i class="fa fa-users"></i> User Responses</a></li>
    </ul>
    <div class="tab-content" style="margin-top: 10px;">
        <div role="tabpanel" class="tab-pane active">
            <div class="col-xs-12">
                {{--<h4>Earl is Real</h4>--}}
                <div class="row no-print">
                    <div class="form-group col-xs-3">
                        <label for="filter-btn" class="control-label">Add Filter:</label>
                        <div class="input-group">
                            <button id="filter-btn" class="btn btn-primary"><span
                                        class="fa fa-plus"> </span> <span id="current-filter"> Filter</span>
                            </button>
                            <div class="dropdown-menu filter-dropdown" style="min-width: 200px;">
                                <div class="ranges">
                                    <ul>
                                        <li data-filter="date">Filter by Date</li>
                                        <li data-filter="question">Filter by Question Answer</li>
                                        {{--<li data-filter="user">Filter by User Information</li>--}}
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
                                <div class="form-group">
                                    <select name="rows" id="question-rows">
                                        <option value="">Select a Row</option>
                                        <option value="">Test</option>
                                        <option value="">Test</option>
                                    </select>
                                </div>
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

                @yield('results')

            </div>
        </div>
    </div>


@endsection

