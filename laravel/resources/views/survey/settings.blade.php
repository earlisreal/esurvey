@extends('layouts.app-with-sidebar')

@section('style')
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('public/plugins/datepicker/datepicker3.css') }}">
    <style>
        .form-control[readonly] {
            background-color: #ffffff;
        }
    </style>
@endsection

@section('content-header')

    <section class="content-header">
        <h1><a href="{{ url('survey/'.$survey->id) }}">{{ $survey->survey_title }}
                <small>Settings</small>
            </a></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('mysurveys') }}">My Surveys</a></li>
            <li><a href="{{ url('survey/'.$survey->id) }}">{{ $survey->survey_title }}</a></li>
            <li class="active">Settings</li>
        </ol>
    </section>
@endsection

@section('content')

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form class="form-horizontal" action="{{ url('settings/'.$survey->id) }}" method="post">
        <div class="box box-solid box-primary">

            <div class="box-header">
                <h3 class="box-title">Survey Options</h3>
            </div>
            <div class="box-body">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group">
                    <label for="response_message" class="col-xs-4">Message for Response:</label>
                    <div class="radio col-xs-8">
                        <textarea name="response_message" id="response_message" class="form-control"
                                  rows="3">{{ $option->response_message }}</textarea>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-xs-4">Multiple Responses:</label>
                    <div class="radio col-xs-8">
                        <label>
                            <input id="multiple-off" type="radio"
                                   name="multiple_responses" value="0" {{ $option->multiple_responses ? '' : 'checked' }}>
                            Off
                        </label>
                        <label>
                            <input type="radio"
                                   name="multiple_responses" value="1" {{ $option->multiple_responses ? 'checked' : '' }}>
                            On
                        </label>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-xs-4">Target Responses: <br>
                        <small>Close After reaching the target number</small>
                    </label>
                    <div class="radio col-xs-4">
                        <label>
                            <input id="target-off" type="radio" value="0"
                                   name="target_responses" {{ is_null($option->target_responses) ? 'checked' : '' }}>
                            Off
                        </label>

                        <label>
                            <input type="radio" value="1"
                                   name="target_responses" {{ is_null($option->target_responses) ? '' : 'checked' }}>
                            On
                        </label>
                    </div>
                    <div class="col-xs-4">
                        <input {{ is_null($option->target_responses) ? 'disabled' : '' }} id="target-number" type="number" value="{{ $option->target_responses }}"
                               class="form-control" name="target_number"
                               placeholder="Enter a number" min="{{ $survey->responses->count() + 1 }}">
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-xs-4">Date Close: <br>
                        <small>Open Survey until date</small>
                    </label>
                    <div class="radio col-xs-4">
                        <label>
                            <input id="date-off" type="radio" value="0"
                                   name="date_close" {{ is_null($option->date_close) ? 'checked' : '' }}>
                            Off
                        </label>
                        <label>
                            <input type="radio" value="1"
                                   name="date_close" {{ is_null($option->date_close) ? '' : 'checked' }}>
                            On
                        </label>
                    </div>
                    <div class="col-xs-4"
                         id="closing-date-div">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input {{ is_null($option->date_close) ? 'disabled' : '' }} type="text" id="closing-date" name="closing_date" class="form-control"
                                   value="{{ \Carbon\Carbon::parse($option->date_close)->format('F d, Y') }}">
                        </div>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-xs-4">Require Registration: <br>
                        <small>Only Registered users can answer</small>
                    </label>
                    <div class="radio col-xs-8">
                        <label>
                            <input id="multiple-off" type="radio" value="0"
                                   name="register_required" {{ $option->register_required ? '' : 'checked' }}>
                            Off
                        </label>
                        <label>
                            <input type="radio" value="1"
                                   name="register_required" {{ $option->register_required ? 'checked' : '' }}>
                            On
                        </label>
                    </div>
                </div>

            </div>
            <div class="box-footer">
                <button id="apply-btn" type="submit" class="btn btn-primary pull-right" style="margin-left: 15px"><i
                            class="fa fa-btn fa-save"></i>Apply Changes
                </button>
            </div>

        </div>
    </form>
@endsection

@section('scripts')
    <!-- Date Picker -->
    <script src="{{ asset('public/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    {{--<script>--}}
    {{--var minTarget = {{ $survey->responses->count() + 1 }};--}}
    {{--var survey_open = {{ $option->open }};--}}
    {{--var multipleInitial = {{ $option->multiple_responses }};--}}
    {{--var targetInitial = {{ is_null($option->target_responses) ? 0 : 1 }};--}}
    {{--var dateInitial = {{ is_null($option->date_close) ? 0 : 1 }};--}}
    {{--var initialTarget = {{ is_null($option->target_responses) ? -1 : $option->target_responses }};--}}
    {{--var initialDate = '{{ is_null($option->date_close) ? 0000-00-00 : $option->date_close }}';--}}
    {{--</script>--}}
    <script src="{{ asset('public/js/share.js') }}"></script>
@endsection