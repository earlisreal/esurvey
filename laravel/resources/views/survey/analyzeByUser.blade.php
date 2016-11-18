<?php $responseCount = $survey->responses()->count(); ?>

@extends('layouts.app')

@section('header')
    @include('common.header')
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

{{--  RESPONSE DETAILS --}}

<div class="modal fade" id="response-details-modal" tabindex="-1" page="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Response Details</h4>
            </div>
            <div class="modal-body">
                <button id="prev-btn" data-increment="-1" type="button" class="btn btn-default change-selected-index"><span class="fa fa-arrow-left"></span> Prev Response</button>
                <button id="next-btn" data-increment="1" type="button" class="btn btn-default change-selected-index pull-right">Next Response <span class="fa fa-arrow-right"></span></button>

                <div class="row">
                    <div id="user-response-details" class="col-xs-12" style="margin-top: 10px; ">

                    </div>
                </div>

                <button id="prev-btn" data-increment="-1" type="button" class="btn btn-default change-selected-index"><span class="fa fa-arrow-left"></span> Prev Response</button>
                <button id="next-btn" data-increment="1" type="button" class="btn btn-default change-selected-index pull-right">Next Response <span class="fa fa-arrow-right"></span></button>
            </div>

            <div class="modal-footer">
                <button type="button" tabindex="-1" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{--  RESPONSE DETAILS END --}}

<ul class="nav nav-tabs">
    <li role="presentation"><a href="{{ url('/analyze/' .$survey->id .'?tab=summary') }}" aria-controls="home" role="tab"><i class="fa fa-pie-chart"></i> Summary</a></li>
    <li role="presentation" class="active"><a href="{{ url('/analyze/' .$survey->id .'?tab=user') }}" aria-controls="by-user" role="tab"><i class="fa fa-users"></i> User Responses</a></li>
</ul>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active">
        <div class="col-xs-12 table-responsive">
            <h4></h4>
            @if($responseCount > 0)
            <div class="form-group">
                <label for="filter-btn" class="control-label">Filter:</label>
                <div class="input-group">
                    <button id="filter-btn" class="btn btn-primary daterange-btn"><span class="fa fa-filter"></span> <span id="current-filter"> None</span></button>
                </div>
            </div>
            <table id="response-table" class="dataTable table table-bordered table-hover">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Date Time</th>
                    <th>Source</th>
                    <th>IP</th>
                    <th>{{ $survey->pages->first()->questions->first()->question_title }}</th>
                </tr>
                </thead>
                <tbody>
                <?php $no = 1; ?>
                @foreach($survey->responses as $response)
                    <tr class="editable response-row" data-response-id="{{ $response->id }}">
                        <td>{{ $no++ }}</td>
                        <td class="response-date">{{ \Carbon\Carbon::parse($response->created_at)->toDayDateTimeString() }}</td>
                        <td>{{ $response->source }}</td>
                        <td>{{ $response->source_ip }}</td>
                        <td>
                            <?php
                            //                              var_dump($response->responseDetails)
                            ?>
                            @if($survey->pages->first()->questions->first()->questionType->has_choices)
                                {{ $response->responseDetails->first()->choice->label }}
                            @else
                                {{ $response->responseDetails->first()->text_answer }}
                            @endif
                        </td>

                    </tr>
                @endforeach

                </tbody>
            </table>

            @else

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>No Responses</h3>
                    </div>
                </div>

            @endif

        </div>


    </div>
</div>

@endsection

@if($responseCount > 0)
@section('scripts')
    <script>
        var responseCount = {{ $no-1 }};
        var startDate = '{{ $survey->responses()->orderBy('created_at')->first()->created_at }}';
    </script>
    <!-- SCRIPT -->
    <script src="{{ asset('public/js/result-functions.js') }}"></script>
@endsection
@endif