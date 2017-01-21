@if($filters['count'] > 0)
    <div class="row no-print">
        <div class="col-xs-5">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Filters
                        <button type="button" class="close remove-filter" data-toggle="tooltip"
                                title="Remove All Filters"
                                data-key="all" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </h3>
                </div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                        @if(!empty($filters['date']))
                            <tr>
                                <td>
                                    <b>Date: </b>
                                    {{ $filters['date']['start'] }} to {{ $filters['date']['end'] }}
                                </td>
                                <td>
                                    <button type="button" class="close remove-filter" data-toggle="tooltip"
                                            title="Remove Filter"
                                            data-key="date" data-dismiss="modal" aria-label="Close"><span
                                                aria-hidden="true">&times;</span></button>
                                </td>
                            </tr>
                        @endif
                        @if(!empty($filters['question']))
                            @foreach($filters['question'] as $id => $values)

                                <?php $question = \App\Question::find($id); ?>
                                @if($question->questionType->type == "Likert Scale")

                                    @foreach($values as $key => $value)
                                        <tr>
                                            <td>
                                                <b>{{ $question->question_title }}: </b>
                                                {{ \App\QuestionRow::find($key)->label }} :
                                                @foreach($value as $choice)
                                                    {{ \App\QuestionChoice::find($choice)->label }},
                                                @endforeach
                                            </td>
                                            <td>
                                                <button type="button" class="close remove-filter" data-toggle="tooltip"
                                                        title="Remove Filter" data-id="{{ $id }}" data-row="{{ $key }}"
                                                        data-key="question" data-dismiss="modal"
                                                        aria-label="Close"><span
                                                            aria-hidden="true">&times;</span></button>
                                            </td>
                                        </tr>

                                    @endforeach
                                @elseif($question->questionType->type == "Text Area" ||
                                 $question->questionType->type == "Textbox" ||
                                 $question->questionType->type == "Rating Scale")
                                    <tr>
                                        <td>
                                            <b>{{ $question->question_title }}: </b>
                                            @foreach($values as $value)
                                                {{ $value }},
                                            @endforeach
                                        </td>
                                        <td>
                                            <button type="button" class="close remove-filter" data-toggle="tooltip"
                                                    title="Remove Filter" data-id="{{ $question->id }}"
                                                    data-key="question" data-dismiss="modal" aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>
                                            <b>{{ $question->question_title }}: </b>
                                            @foreach($values as $value)
                                                {{ \App\QuestionChoice::find($value)->label }},
                                            @endforeach
                                        </td>
                                        <td>
                                            <button type="button" class="close remove-filter" data-toggle="tooltip"
                                                    title="Remove Filter" data-id="{{ $question->id }}"
                                                    data-key="question" data-dismiss="modal" aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                        </td>
                                    </tr>
                                @endif

                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif

<h3>Respondents: {{ $totalResponse }} of {{ $responseCount }}</h3>