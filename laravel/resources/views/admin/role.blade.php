@extends('layouts.admin')

@section('content-header')
    <section class="content-header">
        <h1>
            User Role
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">User Roles</li>
        </ol>
    </section>
@endsection

@section('content')
    <!-- Edit Page Title Modal -->
    <div class="modal fade" id="permission-modal" tabindex="-1" page="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="permission-modal-content">

            </div>
        </div>
    </div>

    @if($right->can_write)
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa fa-btn fa-plus"></i>New Role
                </button>
            </div>
            <div class="collapse {{ count($errors) > 0 ? 'in' : '' }}" id="collapseExample">
                <div class="well">
                    <form class="form-horizontal" role="form" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                            <label for="title" class="col-md-4 control-label">Role Title</label>

                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}">

                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title" class="col-md-4 control-label">Set Permission</label>

                            <div class="col-md-6">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <td>Module</td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-default" id="new-read">
                                                <i class="fa fa-btn fa-check-square-o"></i>Read
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-default" id="new-write">
                                                <i class="fa fa-btn fa-check-square-o"></i>Write
                                            </button>
                                        </td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($modules as $module)
                                        <tr data-id="{{ $module->id }}">
                                            <td>{{ $module->title }}</td>
                                            <td class="text-center">
                                                <input class="new-read" type="checkbox" value="1" name="read{{ $module->id }}">
                                            </td>
                                            <td class="text-center">
                                                <input class="new-write" type="checkbox" value="1" name="write{{ $module->id }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    @endif


    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Role List</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table dataTable table-hover">
                        <thead>
                        <tr>
                            <td>No</td>
                            <td>Role</td>
                            <td>Users</td>
                            <td>Created</td>
                            @if($right->can_write)
                            <td>Permission</td>
                            <td>Edit</td>
                            <td>Delete</td>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=0; ?>
                        @foreach($roles as $role)
                            <tr data-title="{{ $role->title }}" data-id="{{ $role->id }}">
                                <td>{{ ++$no }}</td>
                                <td>{{ $role->title }}</td>
                                <td>{{ $role->users->count() }}</td>
                                <td>{{ \Carbon\Carbon::parse($role->created_at)->format('F d, Y h:m A') }}</td>
                                @if($right->can_write)
                                <td>
                                    <button class="btn btn-info permission"><i class="fa fa-btn fa-check"></i>Set Permission</button>
                                </td>
                                <td>
                                    <button class="btn btn-primary edit"><i class="fa fa-btn fa-pencil-square-o"></i>Edit</button>
                                </td>
                                <td>
                                    <form action="roles/delete/{{ $role->id }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button" data-id="{{ $role->id }}" class="btn btn-danger delete"><i class="fa fa-btn fa-trash"></i>Delete</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
@endsection

@section('scripts')
    <script src="{{ asset('public/js/role.js') }}"></script>
@endsection