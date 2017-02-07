<div class="question-row-container">

    <div class="question-row-tools editable"  data-toggle="modal" data-target="#add-question-modal">
        <div class="col-xs-offset-7 col-xs-5">
            <div class="question-actions">
                <button type="button" data-action="move_question" class="btn btn-facebook move-question"><i class="fa fa-btn fa-cut"></i>Move</button>
                <button type="button" data-action="copy_question" class="btn btn-primary copy-question"><i class="fa fa-btn fa-copy"></i>Replicate</button>
                <button type="button" class="btn btn-danger delete-question"><i class="fa fa-btn fa-eraser"></i>Delete</button>
            </div>
        </div>
    </div>

    <div id="question{{ $question->id }}" class="row question-row" data-max-rating="{{ $question->option == null ? 3 : $question->option->max_rating }}" data-question-id="{{ $question->id }}" data-question-type="{{ $question->questionType->id }}" data-is-mandatory="{{ $question->is_mandatory }}" data-has-choices="{{ $question->questionType->has_choices }}">
        <?php $type = $question->questionType ?>
        <div class="col-xs-12 height-adjuster">
            <div class="form-group">
                <label>
                    <h3>
                        <span class="question-number"></span>
                        <span class="question-dot">.</span>
                        <span class="question-title">{{ $question->question_title }}</span>
                    </h3>
                </label>
                @if($type->type == "Multiple Choice")
                    @foreach($question->choices()->get() as $choice)
                        <div class="radio choice-row" data-choice-id="{{ $choice->id }}">
                            <label class="choice-label"><input type="radio"> {{ $choice->label }}</label>
                        </div>
                    @endforeach
                @elseif($type->type == "Dropdown")
                    <select class="form-control">
                        @foreach($question->choices()->get() as $choice)
                            <option class="choice-row choice-label" data-choice-id="{{ $choice->id }}">{{ $choice->label }}</option>
                        @endforeach
                    </select>
                @elseif($type->type == "Checkbox")
                    @foreach($question->choices()->get() as $choice)
                        <div class="checkbox choice-row" data-choice-id="{{ $choice->id }}">
                            <label class="choice-label"><input type="checkbox"> {{ $choice->label }}</label>
                        </div>
                    @endforeach
                @elseif($type->type == "Rating Scale")
                    <select class="rating-scale">
                        <option value="-1"></option>
                        @for($i=1; $i<=$question->option->max_rating; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                @elseif($question->questionType->type == "Textbox")
                    <div class="form-group">
                        <input type="text" class="form-control">
                    </div>
                @elseif($question->questionType->type == "Text Area")
                    <div class="form-group">
                        <textarea cols="30" rows="2" class="form-control"></textarea>
                    </div>
                @elseif($type->type == "Likert Scale")
                    @foreach($question->choices as $choice)
                        <label hidden class="choice-label" data-weight="{{ $choice->weight }}">{{ $choice->label }}</label>
                    @endforeach
                    <table class="table">
                        <tbody>
                        @foreach($question->rows as $row)
                            <tr>
                                <th class="likert-row">{{ $row->label }}</th>
                                @foreach($question->choices as $choice)
                                    <td>
                                        <label class="radio-inline">
                                            <input type="radio" name="{{ $question->id }}">
                                            {{ $choice->label }}
                                        </label>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>


</div>