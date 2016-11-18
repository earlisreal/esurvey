@extends('layouts.app')

@section('content-header')

    <section class="content-header">

        <h1 class="text-center"><i class="fa fa-gear"></i> Account <small>settings</small></h1>
    </section>

@endsection

@section('content')

@section('header')
    @include('common.header')
@endsection

<div class="container">
    <div class="row">

        <div class="col-lg-offset-1 col-lg-10">
            <div class="box box-solid box-primary">
                <div class="box-header">
                    <h3 class="box-title">{{ $user->username }}</h3>
                </div>
                <div class="box-body">
                    <div class="col-lg-7">

                        @if(session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="profile" method="POST" role="form" class="form-horizontal">
                            {{ csrf_field() }}
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <label for="first_name" class="control-label col-md-4">First Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $user->first_name }}">
                                    @if( $errors->has('first_name') )
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <label for="last_name" class="control-label col-md-4">Last Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $user->last_name }}">
                                    @if( $errors->has('last_name') )
                                        <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label col-md-4">Email</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="email" id="email" value="{{ $user->email }}">
                                    @if( $errors->has('email') )
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('old_password') ? ' has-error' : '' }}">
                                <label for="old_password" class="control-label col-md-4">Old Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="old_password" id="old_password">
                                    @if( $errors->has('old_password') )
                                        <span class="help-block">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">New Password</label>

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
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Apply Changes
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="col-lg-5">
                        <form action="profile" method="POST" role="form" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            <div class="form-group">
                                <img class="img-responsive" src="{{ $user->picture() }}" width="320" height="320" alt="">
                            </div>
                            <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                                <label for="photo">Change Picture</label>
                                <input type="file" id="photo" name="photo" accept="image/*">
                                @if( $errors->has('photo') )
                                <span class="help-block">
                                    <strong>{{ $errors->first('photo') }}</strong>
                                </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-default">
                                    <i class="fa fa-upload"></i> Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection