@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-offset-2 col-lg-8">
            @if(session('thankyou'))
                <h1>{{ session('thankyou') }}</h1>
            @else
                <h1>{{ $survey->survey_title }}</h1>
                <?php $questionNo = 1; ?>
                <form role="form" method="POST" action="{{ url('/answer/'.$survey->id) }}">
                    {{ csrf_field() }}
                    @foreach($survey->pages()->orderBy('page_no')->get() as $page)
                        <div class="page-row">
                            {{--<h4 class="survey-page-header">--}}
                            {{--<span class="page-no">--}}
                            {{--Page {{ $page->page_no }}--}}
                            {{--</span>--}}
                            {{--</h4>--}}
                            <div class="panel panel-primary">

                                <div class="panel-heading">
                                    <h3 class="panel-title">{{ $survey->survey_title }}</h3>
                                </div>


                                @if($page->page_title != "" && $page->page_title != null)
                                    <div class="panel-footer">
                                        {{ $page->page_title }}
                                    </div>
                                @endif

                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <p class="page-description">{{ $page->page_description }}</p>
                                        </div>
                                    </div>

                                    <h4 class="text-red">* Means Required</h4>

                                    @foreach($page->questions()->orderBy('order_no')->get() as $question)
                                        <?php
                                        $hasError = false;
                                        $type = $question->questionType->type;
                                        if ($type == "Likert Scale") {
                                            foreach ($question->rows as $row) {
                                                if ($errors->has('row' . $row->id)) {
                                                    $hasError = true;
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label for="{{ $question->id }}">
                                                        <h3 class="{{ $errors->has('question'.$question->id) || $hasError ? ' text-red scroll' : '' }}">
                                                            <span class="question-number">{{ $questionNo++ }}</span>
                                                            <span class="question-dot">.</span>
                                                            <span class="question-title">{{ $question->question_title }}</span>
                                                            @if($question->is_mandatory)
                                                                <span class="text-red">*</span>
                                                            @endif
                                                        </h3>
                                                    </label>

                                                    @if($type == "Multiple Choice")
                                                        @foreach($question->choices()->get() as $choice)
                                                            <div class="form-group">
                                                                <label for="{{ $question->id }}" class="editable">
                                                                    <input type="radio"
                                                                           name="question{{ $question->id }}"
                                                                           {{ old('question'.$question->id) == $choice->id ? 'checked' : '' }}
                                                                           value="{{ $choice->id }}" {{ $question->is_mandatory ? 'required' : '' }}>
                                                                    {{ $choice->label }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @elseif($type == "Dropdown")
                                                        <select class="form-control"
                                                                name="question{{ $question->id }}" {{ $question->is_mandatory ? 'required' : '' }}>
                                                            <option value="">Please Select</option>
                                                            @foreach($question->choices()->get() as $choice)
                                                                <option value="{{ $choice->id }}" {{ old('question'.$question->id) == $choice->id ? 'selected' : '' }}>{{ $choice->label }}</option>
                                                            @endforeach
                                                        </select>
                                                    @elseif($type == "Checkbox")
                                                        @foreach($question->choices()->get() as $choice)
                                                            <div class="form-group">
                                                                <label for="{{ $question->id }}" class="editable">
                                                                    <input type="checkbox"
                                                                           name="question{{ $question->id }}[]"
                                                                           value="{{ $choice->id }}"> {{ $choice->label }}
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    @elseif($type == "Rating Scale")
                                                        <select class="rating-scale" name="question{{ $question->id }}">
                                                            <option value=""></option>
                                                            @for($i=1; $i<=$question->option->max_rating; $i++)
                                                                <option value="{{ $i }}">{{ $i }}</option>
                                                            @endfor
                                                        </select>
                                                    @elseif($type == "Textbox")
                                                        <input type="text" name="question{{ $question->id }}"
                                                               id="question{{ $question->id }}" class="form-control"
                                                               value="{{ old('question'.$question->id) }}"
                                                                {{ $question->is_mandatory ? 'required' : '' }}>
                                                    @elseif($type == "Text Area")
                                                        <textarea name="question{{ $question->id }}"
                                                                  id="question{{ $question->id }}" cols="30" rows="4"
                                                                  class="form-control" {{ $question->is_mandatory ? 'required' : '' }}>{{ old('question'.$question->id) }}</textarea>
                                                    @elseif($type == "Likert Scale")
                                                        <table class="table">
                                                            <tbody>
                                                            @foreach($question->rows as $row)
                                                                <tr>
                                                                    <th>{{ $row->label }}</th>
                                                                    @foreach($question->choices as $choice)
                                                                        <td>
                                                                            <label for="{{ $question->id }}"
                                                                                   class="radio-inline">
                                                                                <input type="radio"
                                                                                       name="row{{ $row->id }}"
                                                                                       {{ old('row'.$row->id) == $row->id ? 'checked' : '' }}
                                                                                       value="{{ $choice->id }}" {{ $question->is_mandatory ? 'required' : '' }}>
                                                                                {{ $choice->label }}
                                                                            </label>
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                            </tbody>

                                                            @if ($hasError)
                                                                <tfoot>
                                                                <tr>
                                                                    <td>
                                                                        <span class="help-block text-red">
                                                                            <strong>Please Rate all the Fields.</strong>
                                                                        </span>
                                                                    </td>
                                                                </tr>
                                                                </tfoot>
                                                            @endif
                                                        </table>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="form-group">

                        <button type="submit" class="btn btn-lg btn-facebook center-block"><i
                                    class="fa fa-btn fa-share"></i>Submit
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        console.log("earl is rteal");
        $('.rating-scale').barrating({
            theme: 'fontawesome-stars',
            // showValues: true,
            showSelectedRating: false,
            emptyValue: ""
        });
        if ($('.scroll').size() > 0) {
            scrollTo($('.scroll').first());
        }
    </script>
@endsection
