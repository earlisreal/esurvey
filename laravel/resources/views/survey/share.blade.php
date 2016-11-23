@extends('layouts.app')

@section('style')
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('public/plugins/datepicker/datepicker3.css') }}">
    <style>
        .form-control[readonly] {
            background-color: #ffffff;
        }
    </style>
@endsection

@section('header')
    @include('common.header')
@endsection

@section('content-header')
    <section class="content-header">
        <h1><a href="{{ url('survey/'.$survey->id) }}">{{ $survey->survey_title }}</a></h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="{{ url('mysurveys') }}">My Surveys</a></li>
            <li><a href="{{ url('survey/'.$survey->id) }}">{{ $survey->survey_title }}</a></li>
            <li class="active">Share</li>
        </ol>
    </section>
@endsection

@section('content')
    <script>
        window.fbAsyncInit = function () {
            FB.init({
                appId: '1763279543936020',
                xfbml: true,
                version: 'v2.7'
            });
        };

        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    {{--<div id="fb-root"></div>--}}
    {{--<script>(function(d, s, id) {--}}
    {{--var js, fjs = d.getElementsByTagName(s)[0];--}}
    {{--if (d.getElementById(id)) return;--}}
    {{--js = d.createElement(s); js.id = id;--}}
    {{--js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1";--}}
    {{--fjs.parentNode.insertBefore(js, fjs);--}}
    {{--}(document, 'script', 'facebook-jssdk'));</script>--}}

    {{--<div id="fb-root"></div>--}}
    {{--<script>(function(d, s, id) {--}}
    {{--var js, fjs = d.getElementsByTagName(s)[0];--}}
    {{--if (d.getElementById(id)) return;--}}
    {{--js = d.createElement(s); js.id = id;--}}
    {{--js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.7&appId=1763279543936020";--}}
    {{--fjs.parentNode.insertBefore(js, fjs);--}}
    {{--}(document, 'script', 'facebook-jssdk'));</script>--}}

    <div class="col-lg-offset-3 col-lg-6 col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Share Your Survey</h3>
            </div>
            <div class="panel-body">
                <p>Survey Status: <strong id="survey-status">{{ $survey->option->open ? "Open" : "Closed" }}</strong>
                </p>
                <div class="form-group">
                    <button class="btn btn-primary"
                            id="close-open-survey">{{ $survey->option->open ? "Close Survey" : "Open Survey" }}</button>
                </div>
                <div class="form-group">
                    <label for="url">Survey URL</label>
                    <input id="url" type="text" class="form-control" value="{{ url('/answer/'.$survey->id) }}" readonly>
                </div>

                <div class="row">
                    <div class="col-xs-3">
                        <div class="fb-share-button"
                             data-href="{{ url('answer/'.$survey->id) }}"
                             data-layout="button_count">
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <a class="twitter-share-button"
                           href="https://twitter.com/share"
                           data-size="default"
                           data-url="{{ url('answer/'.$survey->id) }}"
                           data-via="e-survey.xyz"
                           data-related="twitterapi,twitter"
                           data-hashtags="eSurvey"
                           data-text="Take my quick Survey ">
                            Tweet
                        </a>
                    </div>
                </div>


            </div>

        </div>

        <div class="box box-solid box-primary">
            <div class="box-header">
                <h3 class="box-title">Survey Options</h3>
            </div>
            <div class="box-body">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="response_message" class="col-xs-4">Message for Response:</label>
                        <div class="radio col-xs-8">
                            <textarea name="response_message" id="response_message" class="form-control" rows="3">{{ $survey->option->response_message }}</textarea>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label class="col-xs-4">Multiple Responses:</label>
                        <div class="radio col-xs-8">
                            <label>
                                <input id="multiple-off" type="radio"
                                       name="multiple-responses" {{ $survey->option->multiple_responses ? '' : 'checked' }}>
                                Off
                            </label>
                            <label>
                                <input type="radio"
                                       name="multiple-responses" {{ $survey->option->multiple_responses ? 'checked' : '' }}>
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
                                <input id="target-off" type="radio"
                                       name="target-responses" {{ is_null($survey->option->target_responses) ? 'checked' : '' }}>
                                Off
                            </label>

                            <label>
                                <input type="radio"
                                       name="target-responses" {{ is_null($survey->option->target_responses) ? '' : 'checked' }}>
                                On
                            </label>
                        </div>
                        <div class="col-xs-4">
                            <input id="target-number" type="number" value="{{ $survey->option->target_responses }}"
                                   class="form-control {{ is_null($survey->option->target_responses) ? 'collapse' : '' }}"
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
                                <input id="date-off" type="radio"
                                       name="date-close" {{ is_null($survey->option->date_close) ? 'checked' : '' }}>
                                Off
                            </label>
                            <label>
                                <input type="radio"
                                       name="date-close" {{ is_null($survey->option->date_close) ? '' : 'checked' }}>
                                On
                            </label>
                        </div>
                        <div class="col-xs-4 {{ is_null($survey->option->date_close) ? 'collapse' : '' }}"
                             id="closing-date-div">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="closing-date" class="form-control"
                                       value="{{ $survey->option->date_close }}">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="box-footer">
                <button id="apply-btn" class="btn btn-primary pull-right" disabled style="margin-left: 15px"><i
                            class="fa fa-btn fa-cog"></i>Apply Changes
                </button>
            </div>
        </div>

    </div>




@endsection


@section('scripts')
    <script>window.twttr = (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0],
                    t = window.twttr || {};
            if (d.getElementById(id)) return t;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://platform.twitter.com/widgets.js";
            fjs.parentNode.insertBefore(js, fjs);

            t._e = [];
            t.ready = function (f) {
                t._e.push(f);
            };

            return t;
        }(document, "script", "twitter-wjs"));</script>
    <!-- Date Picker -->
    <script src="{{ asset('public/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script>
        var minTarget = {{ $survey->responses->count() + 1 }};
        var survey_open = {{ $survey->option->open }};
        var multipleInitial = {{ $survey->option->multiple_responses }};
        var targetInitial = {{ is_null($survey->option->target_responses) ? 0 : 1 }};
        var dateInitial = {{ is_null($survey->option->date_close) ? 0 : 1 }};
        var initialTarget = {{ is_null($survey->option->target_responses) ? -1 : $survey->option->target_responses }};
        var initialDate = '{{ is_null($survey->option->date_close) ? 0000-00-00 : $survey->option->date_close }}';
    </script>
    <script src="{{ asset('public/js/share.js') }}"></script>
@endsection