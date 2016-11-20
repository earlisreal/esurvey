@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Activate Account</h3>
            </div>
            <div class="panel-body text-center">
                <i class="center-block fa fa-envelope fa-5x"></i>
                <h3>Please Verify your Email</h3>
                <p>We sent an email to <b>{{ $user->email }}</b>.Please click the activation link to have a full
                    experience using eSurvey! If you didn't see the confirmation in your inbox, please check your spam
                    folder. </p>
                <div class="form-group">
                    <a href="resend" class="btn btn-default btn-lg btn-lg">Resend Verification</a>
                    <a href="verify?change" class="btn btn-default btn-lg btn-lg">Change Email</a>
                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat btn-lg">Sign out</a>
                </div>
                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if(isset($_GET['change']))
                    <form action="verify/change" class="form-horizontal" method="get">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">Change Email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email">

                                @if($errors->has('email'))
                                    <span class="help-block"><b>{{ $errors->first('email') }}</b></span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-6">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection