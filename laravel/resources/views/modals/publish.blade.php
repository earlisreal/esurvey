<!-- Publish Modal / Theme Picker -->
<div class="modal fade" id="publish-modal" tabindex="-1" page="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <form id="question-modal-form" class="form-horizontal" role="form" method="POST">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Publish Survey</h4>
                </div>
                <div class="modal-body">
                    <h3>Proceed? You cannot make changes anymore if you do.</h3>
                    {{ csrf_field() }}
                    {{ method_field('PATCH') }}
                    Choose your theme (you can change this later at the settings).
                    <div class="row text-center">
                        <div class="col-xs-12">
                            <label class="radio-inline">
                                <input type="radio" name="theme" value="blue" checked>
                                <div class="sample-circle bg-blue"></div>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="theme" value="red">
                                <div class="sample-circle bg-red"></div>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="theme" value="yellow">
                                <div class="sample-circle bg-yellow"></div>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="theme" value="green">
                                <div class="sample-circle bg-green"></div>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="theme" value="aqua">
                                <div class="sample-circle bg-aqua"></div>
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="theme" value="gray">
                                <div class="sample-circle bg-gray"></div>
                            </label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" tabindex="-1" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-facebook" id="save-question">Continue</button>
                </div>

            </form>
        </div>
    </div>
</div>