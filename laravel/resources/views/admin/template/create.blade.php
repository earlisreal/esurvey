@extends('layouts.admin')

@section('content-header')
    <section class="content-header">
        <h1>
            Create New Survey Template
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Templates</li>
            <li class="active">Create</li>
        </ol>
    </section>
@endsection

@section('content')
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                {{--CREATE FROM SCRATCH--}}
                <div class="panel panel-default" style="margin-bottom: 0px;">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                        <div class="panel-heading editable">
                            <h4>
                                {{--<input type="radio" name="create_from" value="scratch" id="scratch" class="header-radio" checked>--}}
                                Create from Scratch

                            </h4>
                        </div>

                    </a>
                    <div id="collapseOne" class="panel-collapse collapse {{ $errors->count()  < 1 || $errors->has('survey_title') || $errors->has('category')? 'in' : '' }}" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body" id="from-scratch">
                            <form class="form-horizontal" action="{{ url('create') }}" role="form" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="create_from" value="scratch">
                                <input type="hidden" name="is_template" value="1">
                                <div class="form-group{{ $errors->has('survey_title') ? ' has-error' : '' }}">
                                    <label for="title" class="col-md-4 control-label">Title* </label>

                                    <div class="col-md-6">
                                        <input id="title" type="text" class="form-control" name="survey_title" maxlength="250" placeholder="Title of your survey" value="{{ old('survey_title') }}">

                                        <span class="help-block">
                                           @if ($errors->has('survey_title'))
                                                <strong>{{ $errors->first('survey_title') }}</strong>
                                            @else
                                                <small>Up to 250 characters</small>
                                            @endif
                                        </span>

                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                                    <div class="col-md-offset-4 col-md-6">
                                        <select class="form-control" name="category">
                                            <option value="">Select Category</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->category }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">
                                            @if ($errors->has('category'))
                                                <strong>{{ $errors->first('category') }}</strong>
                                            @endif
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-4 col-xs-6">
                                        <button type="submit" class="btn btn-facebook">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default" style="margin-bottom: 0px;">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">

                        <div class="panel-heading editable">
                            <h4>
                                {{--<input type="radio" name="create_from" value="template" id="template" class="header-radio">--}}
                                Create from a Template

                            </h4>

                        </div>
                    </a>
                    <div id="collapseThree" class="panel-collapse collapse {{ $errors->has('survey_template') ? 'in' : '' }}" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body" id="from-template">
                            <form class="form-horizontal" action="{{ url('/create') }}" role="form" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="create_from" value="template">
                                <input type="hidden" name="is_template" value="1">
                                <div class="form-group{{ $errors->has('survey_template') ? ' has-error' : '' }}">
                                    <label for="title" class="col-md-4 control-label">Survey Template* </label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="survey_template">
                                            <option value="">Select Survey Template</option>
                                            @foreach($templates as $template)
                                                <option value="{{ $template->id }}">{{ $template->survey_title }}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block">
                                         @if ($errors->has('survey_template'))
                                                <strong>{{ $errors->first('survey_template') }}</strong>
                                            @endif
                                    </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-4 col-xs-6">
                                        <button type="submit" class="btn btn-facebook">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
@endsection