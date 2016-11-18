@extends('layouts.admin')

@section('content-header')
    <section class="content-header">
        <h1>
            Admin Modules
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Admin Modules</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">New Module</h3>
                </div>
                <div class="box-body">
                    <form class="form-horizontal" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                            <label for="title" class="control-label col-sm-3">Module</label>
                            <div class="col-sm-9">
                                <input id="title" name="title" type="text" class="form-control">
                                @if($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i>Add Module</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Module List</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table dataTable table-hover">
                        <thead>
                        <tr>
                            <td>No</td>
                            <td>Module</td>
                            <td>Created</td>
                            <td>Last Update</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=0; ?>
                        @foreach($modules as $module)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $module->title }}</td>
                                <td>{{ \Carbon\Carbon::parse($module->created_at)->format('F d, y h:m A') }}</td>
                                <td>{{ $module->updated_at }}</td>
                                <td>
                                    <button class="btn btn-primary edit" data-title="{{ $module->title }}" data-id="{{ $module->id }}"><i class="fa fa-btn fa-pencil-square-o"></i>Edit</button>
                                </td>
                                <td>
                                    <form action="categories/delete/{{ $module->id }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button" data-id="category{{ $module->id }}" class="btn btn-danger delete"><i class="fa fa-btn fa-trash"></i>Delete</button>
                                    </form>
                                </td>
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
    <script src="{{ asset('public/js/module.js') }}"></script>
@endsection