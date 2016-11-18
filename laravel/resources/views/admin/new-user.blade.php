<div class="modal fade" id="role-modal" tabindex="-1" page="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <form method="POST">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="user_id" value="" id="user-id">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Change <span id="user-name">Earl</span> Role</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="role" class="control-label">Role</label>
                        <select class="form-control" name="role_id" id="user-role">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-btn fa-save"></i>Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="form-group">
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
        <i class="fa fa-btn fa-plus"></i>New User
    </button>
</div>
<div class="collapse {{ count($errors) > 0 ? 'in' : '' }}" id="collapseExample">
    <div class="well">
        <div class="row">
            <div class="col-md-12">
                <form class="form-horizontal" role="form" method="POST">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('user_role') ? ' has-error' : '' }}">
                        <label for="user_role" class="col-md-4 control-label">Role</label>

                        <div class="col-md-6">
                            <select class="form-control" name="user_role" id="user_role">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->title }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('user_role'))
                                <span class="help-block">
                                <strong>{{ $errors->first('user_role') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username" class="col-md-4 control-label">Username</label>

                        <div class="col-md-6">
                            <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}">

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
                            <input id="first_name" type="text" class="form-control proper-case" name="first_name" value="{{ old('first_name') }}">

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
                            <input id="last_name" type="text" class="form-control proper-case" name="last_name" value="{{ old('last_name') }}">

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
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

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
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

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


{{--<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">--}}
    {{--<div class="panel panel-default">--}}
        {{--<div class="panel-heading" role="tab" id="headingOne">--}}
            {{--<h3 class="panel-title">--}}
                {{--<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">--}}
                    {{--<i class="fa fa-plus"></i> New User--}}
                {{--</a>--}}
            {{--</h3>--}}
        {{--</div>--}}
        {{--<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">--}}
            {{--<div class="panel-body">--}}
                {{----}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}


