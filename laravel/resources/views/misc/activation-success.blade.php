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
        <div class="panel-body text-center">
            <h2>{{ $message }}</h2>
            <h4>If your browser doesn't redirect you to home after 5 seconds<br><a href="{{ url('home') }}">Click here</a></h4>
            {{--<h4 class="text-center"><a href="javascript:history.back()">Go Back</a></h4>--}}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        setTimeout(function () {
            window.location.replace('{{ url('home') }}');
        }, 5000)
    </script>
@endsection