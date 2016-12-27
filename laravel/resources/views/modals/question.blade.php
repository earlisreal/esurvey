<!-- Add Question Modal -->
<div class="modal fade" id="add-question-modal" tabindex="-1" page="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Customize your question</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12" style="margin-top: 10px; ">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="question-modal-form" class="form-horizontal" role="form">

                                    <div class="form-group">
                                        <label class="col-xs-1 control-label" for="question-type-select">Type:</label>
                                        <div class="col-xs-4">
                                            <select id="question-type-select" class="form-control btn btn-default">
                                                @foreach($question_types as $question_type)
                                                    <option class="type-option" value="{{ $question_type->id }}"
                                                            has-choices="{{ $question_type->has_choices }}"
                                                            data-type="{{ $question_type->type }}"
                                                    >{{ $question_type->type }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div id='max-rating-div' class="collapse">
                                            <label class="col-xs-2 control-label" for="max-rating">Max Rate:</label>
                                            <div class="col-xs-5">
                                                <select id="max-rating" class="form-control">
                                                    @for($i = 3; $i <= 10; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                                {{--<input type="number" min="3" max="10" id="max-rating" name="max-rating" placeholder="Max Rating" value="5" class="form-control" required>--}}
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-xs-1 control-label" for="question-title"><strong
                                                    id="modal-question-number">Q1:</strong></label>
                                        <div class="col-xs-11">
                                            <input type="text" id="question-title" name="question-title"
                                                   placeholder="Enter Question Title" class="form-control" required>
                                            {{--<span class="help-block">--}}
                                            {{--<small><strong>error here</strong></small>--}}
                                            {{--</span>--}}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-xs-12">
                                            <label for="mandatory" class="editable">
                                                <input id="question-mandatory" type="checkbox" name="mandatory"
                                                       value="1"> Mandatory Question
                                            </label>
                                        </div>
                                    </div>

                                    <div id="row-container">
                                        <hr>

                                        <table id="modal-rows-table" class="choices-table">
                                            <thead>
                                            <tr>
                                                <th width="100%">
                                                    Question Rows
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="modal-question-row">
                                                <td>
                                                    <input type="text" placeholder="Enter a row label"
                                                           class="form-control modal-row-label">
                                                </td>
                                                <td>
                                                    <button type="button" tabindex="-1"
                                                            class="btn btn-primary add-choice"><span
                                                                class="glyphicon glyphicon-plus"></span></button>
                                                </td>
                                                <td>
                                                    <button type="button" tabindex="-1"
                                                            class="btn btn-danger remove-choice"><span
                                                                class="glyphicon glyphicon-remove"></span></button>
                                                </td>
                                            </tr>

                                            <tr class="modal-question-row">
                                                <td>
                                                    <input id="last-choice-row" type="text"
                                                           placeholder="Enter a row label"
                                                           class="form-control modal-row-label">
                                                </td>
                                                <td>
                                                    <button type="button" tabindex="-1"
                                                            class="btn btn-primary add-choice"><span
                                                                class="glyphicon glyphicon-plus"></span></button>
                                                </td>
                                                <td>
                                                    <button type="button" tabindex="-1"
                                                            class="btn btn-danger remove-choice"><span
                                                                class="glyphicon glyphicon-remove"></span></button>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="choice-container" class="collapse">
                                        <hr>
                                        <table id="modal-choices-table" class="choices-table">
                                            <thead>
                                            <tr>
                                                <th colspan="2">
                                                    Answer Choices
                                                </th>

                                                <th class="weight-field collapse">
                                                    Weight
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="modal-choice-row">
                                                <td class="question-type">
                                                    <input type="radio" disabled>
                                                </td>
                                                <td width="100%">
                                                    <input type="text" placeholder="Enter Choice Label"
                                                           class="form-control modal-choice-label">
                                                </td>
                                                <td class="weight-field collapse" style="min-width: 50px;">
                                                    <input type="text" maxlength="2" class="form-control text-center weight" value="1">
                                                </td>
                                                <td>
                                                    <button type="button" tabindex="-1"
                                                            class="btn btn-primary add-choice"><span
                                                                class="glyphicon glyphicon-plus"></span></button>
                                                </td>
                                                <td>
                                                    <button type="button" tabindex="-1"
                                                            class="btn btn-danger remove-choice"><span
                                                                class="glyphicon glyphicon-remove"></span></button>
                                                </td>
                                            </tr>
                                            <tr class="modal-choice-row">
                                                <td class="question-type">
                                                    <input type="radio" disabled>
                                                </td>
                                                <td width="100%">
                                                    <input type="text" placeholder="Enter Choice Label"
                                                           class="form-control modal-choice-label">
                                                </td>
                                                <td class="weight-field collapse" style="min-width: 50px;">
                                                    <input type="text" maxlength="2" class="form-control text-center weight" value="2">
                                                </td>
                                                <td>
                                                    <button type="button" tabindex="-1"
                                                            class="btn btn-primary add-choice"><span
                                                                class="glyphicon glyphicon-plus"></span></button>
                                                </td>
                                                <td>
                                                    <button type="button" tabindex="-1"
                                                            class="btn btn-danger remove-choice"><span
                                                                class="glyphicon glyphicon-remove"></span></button>
                                                </td>
                                            </tr>
                                            </tbody>


                                        </table>

                                    </div>

                                </form>
                            </div>
                            {{--<ul class="nav nav-tabs" role="tablist">--}}
                            {{--<li role="presentation" class="active"><a href="#question" aria-controls="question" role="tab" data-toggle="tab">Question</a></li>--}}
                            {{--<li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>--}}
                            {{--</ul>--}}
                            {{--<div class="tab-content panel-body">--}}

                            {{--<div role="tabpanel" class="tab-pane active" id="question">--}}

                            {{--</div>--}}

                            {{--<div role="tabpanel" class="tab-pane" id="settings">--}}

                            {{--</div>--}}

                            {{--</div>--}}

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" tabindex="-1" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-facebook" id="save-question">Save Question</button>
            </div>
        </div>
    </div>
</div>