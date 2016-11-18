@extends('layouts.app')

@section('header')
    @include('common.header')
@endsection

@section('content')
<div class="row">
    <div class="col-xs-offset-1 col-xs-10">
        <h3>Build New Survey</h3>
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
                <div id="collapseOne" class="panel-collapse collapse  {{ $errors->count()  < 1 || $errors->has('survey_title') ? 'in' : '' }}" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body" id="from-scratch">
                        <form class="form-horizontal" action="{{ url('/create') }}" role="form" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="create_from" value="scratch">
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

                            <div class="form-group">
                                <div class="col-md-offset-4 col-md-6">
                                    <select class="form-control" name="category">
                                        <option value="-1" selected>Select Category</option>
                                        <optgroup label="Categories">
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->category }}
                                                </option>
                                            @endforeach
                                        </optgroup>

                                        <option value="1">Other</option>
                                    </select>
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

            {{--CREATE FROM EXISTING--}}
            <div class="panel panel-default" style="margin-bottom: 0px;">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <div class="panel-heading editable">
                    <h4>

                            {{--<input type="radio" name="create_from" value="existing" id="existing" class="header-radio">--}}
                            Create from Existing Survey

                    </h4>
                </div>
                </a>
                <div id="collapseTwo" class="panel-collapse collapse {{ $errors->has('existing_survey') ? 'in' : '' }}" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body" id="from-existing">
                        <form class="form-horizontal" action="{{ url('/create') }}" role="form" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="create_from" value="existing">
                            <div class="form-group{{ $errors->has('existing_survey') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">Survey to Replicate* </label>
                                <div class="col-md-6">
                                    <select class="form-control" name="existing_survey">
                                        <option value="">Select Existing Survey</option>
                                        @foreach($surveys as $survey)
                                            <option value="{{ $survey->id }}">{{ $survey->survey_title }}</option>
                                        @endforeach
                                    </select>
                                    <span class="help-block">
                                     @if ($errors->has('existing_survey'))
                                        <strong>{{ $errors->first('existing_survey') }}</strong>
                                    @endif
                                    </span>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('new_title') ? ' has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">Title </label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control" name="new_title" maxlength="250" placeholder="Leave blank to use existing title" value="{{ old('new_title') }}">

                                    <span class="help-block">
                                     @if ($errors->has('new_title'))
                                            <strong>{{ $errors->first('new_title') }}</strong>
                                        @else
                                            <small>Up to 250 characters</small>
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

            {{--CREATE FROM TEMPLATE--}}

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
    </div>
</div>
@endsection

@section('scripts')

    <script src="{{ asset('public/js/create.js') }}"></script>

@endsection