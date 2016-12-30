@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-sm-12">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('public/images/logo.png') }}" height="300px" class="img-responsive center-block">
                </a>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="text-center">{{ $message }}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection