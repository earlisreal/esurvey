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
    <h3 class="text-center">There are no responses. <a href="{{ url('share/'.$survey->id) }}">Share</a> your Survey to collect responses</h3>
@endsection