@extends('layouts.app')

@section('header')
    @include('common.header')
@endsection

@section('style')
    <!-- Date Picker -->
    <link rel="stylesheet" href="{{ asset('public/plugins/datepicker/datepicker3.css') }}">
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-4 control-label">Username</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username"
                                           value="{{ old('username') }}">

                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name" class="col-md-4 control-label">First name</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control proper-case"
                                           name="first_name" value="{{ old('first_name') }}">

                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last_name" class="col-md-4 control-label">Last Name</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control proper-case" name="last_name"
                                           value="{{ old('last_name') }}">

                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{--TODO--}}

                            {{--<hr>--}}

                            {{--<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">--}}
                                {{--<label for="last_name" class="col-md-4 control-label">Gender</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<label>--}}
                                        {{--<input type="radio" name="gender" }}>Male--}}
                                    {{--</label>--}}

                                    {{--<label>--}}
                                        {{--<input type="radio" name="gender" }>Female--}}
                                    {{--</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            {{--<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">--}}
                                {{--<label for="birthday" class="col-md-4 control-label">Birthday</label>--}}

                                {{--<div class="col-md-6">--}}

                                    {{--<div class="input-group">--}}
                                        {{--<input type="text" id="birthday" name="birthday" class="form-control">--}}

                                        {{--<div class="input-group-addon">--}}
                                            {{--<i class="fa fa-calendar"></i>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                    {{----}}
                                    {{--<input id="birthday" type="text" class="form-control datepicker" name="birthday"--}}
                                    {{--value="{{ old('birthday') }}">--}}

                                    {{--@if ($errors->has('birthday'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('birthday') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}

                            {{--</div>--}}

                            {{--<div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">--}}
                                {{--<label for="last_name" class="col-md-4 control-label">Last Name</label>--}}

                                {{--<div class="col-md-6">--}}
                                    {{--<input id="last_name" type="text" class="form-control proper-case" name="last_name"--}}
                                           {{--value="{{ old('last_name') }}">--}}

                                    {{--@if ($errors->has('last_name'))--}}
                                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('last_name') }}</strong>--}}
                                    {{--</span>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa-user"></i> Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('public/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script>
        $('#birthday').datepicker({
            autoclose: true,
        });

    </script>
@endsection
