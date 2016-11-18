<div id="pageid{{ $page->id }}" class="page" data-page="{{ $page->page_no }}" data-id="{{ $page->id }}" data-title="{{ $page->page_title }}" data-description="{{ $page->page_description }}">
    <h4 class="page-no">Page {{ $page->page_no }}</h4>
    <div class="panel panel-default">

        <div class="panel-heading editable survey-title" data-toggle="modal" data-target="#survey-title-modal" value="{{ $survey->survey_title }}">
            {{ $survey->survey_title }}
        </div>

        <div class="panel-heading edit-page-title editable" data-toggle="modal" data-target="#page-title-modal" data-identifier="title">
            @if($page->page_title == "" || $page->page_title == null)
                <span class="glyphicon glyphicon-plus"></span>
                Add Page Title
            @else
                {{ $page->page_title }}
            @endif
        </div>

        <div class="panel-body">

            <div class="row edit-page-description editable" data-toggle="modal" data-target="#page-title-modal" data-identifier="description">
                <div class="col-xs-12">
                    <p class="page-description">{{ $page->page_description }}</p>
                </div>
            </div>

            <div class="question-container">
                {{--AJAX WILL APPEND COMPONENTS HERE--}}

            </div>

            <div class="row">
                <div class="btn-group col-xs-offset-4 add-btn-div">
                    <button type="button" class="btn btn-primary add-question" data-toggle="modal" data-target="#add-question-modal"  data-question-number="" data-page="{{ $page->page_no }}"><i class="fa fa-plus-circle"></i> Add new Question</button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" data-question-number=""><span class="fa fa-caret-down"></span></button>
                        <ul class="dropdown-menu">
                            @foreach($question_types as $question_type)
                                <li class="type-option"><a href="#" id="{{ $question_type->id }}" has-choices="{{ $question_type->has_choices }}">{{ $question_type->type }}</a></li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group">
            <button class="btn btn-lg btn-default add-page col-xs-12" type="button"><span class="fa fa-plus-square-o"></span> Add Page</button>
        </div>

    </div>
</div>