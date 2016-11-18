@extends('layouts.admin')

@section('content-header')
    <section class="content-header">
        <h1>
            Survey Categories
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Survey Categories</li>
        </ol>
    </section>
@endsection

@section('content')

    @if($right->can_write)
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa fa-btn fa-plus"></i>New Category
                </button>
            </div>
            <div class="collapse {{ count($errors) > 0 ? 'in' : '' }}" id="collapseExample">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">New Category</h3>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                                <label for="category" class="control-label col-sm-3">Category</label>
                                <div class="col-sm-9">
                                    <input id="category" name="category" type="text" class="form-control">
                                    @if($errors->has('category'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('category') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-6">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-btn fa-plus"></i>Add Category</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
                    <h3 class="box-title">Category List</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table dataTable table-hover">
                        <thead>
                        <tr>
                            <td>No</td>
                            <td>Category</td>
                            <td>Templates</td>
                            <td>Surveys</td>
                            <td>Edit</td>
                            <td>Delete</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $no=0; ?>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ ++$no }}</td>
                                <td>{{ $category->category }}</td>
                                <td>{{ $category->surveys->where('is_template', 1)->count() }}</td>
                                <td>{{ $category->surveys->count() }}</td>
                                <td>
                                    <button class="btn btn-primary edit" data-category="{{ $category->category }}" data-id="{{ $category->id }}"><i class="fa fa-btn fa-pencil-square-o"></i>Edit</button>
                                </td>
                                <td>
                                    <form action="categories/delete/{{ $category->id }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="button" data-id="category{{ $category->id }}" class="btn btn-danger delete"><i class="fa fa-btn fa-trash"></i>Delete</button>
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
    <script src="{{ asset('public/js/survey-category.js') }}"></script>
@endsection