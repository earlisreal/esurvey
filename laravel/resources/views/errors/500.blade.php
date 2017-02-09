@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-12">
            <a href="{{ url('/') }}">
                <img src="{{ asset('public/images/logo.png') }}" height="300px" class="img-responsive center-block">
            </a>
        </div>
    </div>

    <hr>

    <div class="panel">
        <div class="panel-body">
            <h2 class="text-center">Sorry, Something Went Wrong.</h2>
            <h4 class="text-center"><a href="javascript:history.back()">Go Back</a></h4>
        </div>
    </div>
@endsection