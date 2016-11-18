<?php
$no = 1;
//var_dump($response->responseDetails);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4><b>Response No: </b><span id="response-no"></span></h4>
        <h4><b>Date Answered: </b>{{ \Carbon\Carbon::parse($response->created_at)->format('F d, Y h:i:s A') }}</h4>
        <h4><b>Source Platform: </b>{{ $response->source }}</h4>
        <h4><b>IP: </b>{{ $response->source_ip }}</h4>
    </div>
    <div class="panel-body">
        <form>
            @foreach($response->responseDetails as $detail)
                <div class="row">
                    <div class="form-group">
                        <label class="control-label col-xs-12">
                            Q{{ $no++ .'. ' .$detail->question->question_title }}
                        </label>
                        <label class="control-label col-xs-12">
                            <h5>
                                @if($detail->question->questionType->has_choices)

                                    {!! empty($detail->choice->label) ? '<small>Skipped</small>' : $detail->choice->label !!}
                                @else
                                    {!! empty($detail->text_answer) ? '<small>Skipped</small>' : $detail->text_answer !!}
                                @endif
                            </h5>
                        </label>
                    </div>
                </div>
            @endforeach
        </form>
    </div>
</div>

