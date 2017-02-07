<!-- Move/Copy Page/Question Modal -->
<div class="modal fade" id="move-copy-modal" tabindex="-1" page="-1" role="dialog" aria-labelledby="move-copy-modal-label">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="move-copy-modal-label">Move Page</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12" style="margin-top: 10px; ">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form class="form-horizontal">

                                    {{--<div class="form-group">--}}
                                        {{--<label for="move-position-select" class="control-label col-xs-3">Position</label>--}}
                                        {{--<div class="col-xs-9">--}}
                                            {{--<select name="move-position-select" id="move-position-select" class="form-control">--}}
                                                {{--<option value="above">Above</option>--}}
                                                {{--<option value="below">Below</option>--}}
                                            {{--</select>--}}
                                        {{--</div>--}}

                                    {{--</div>--}}

                                    <div class="form-group">
                                        <label for="target-page-select" class="control-label col-xs-3">Page</label>
                                        <div class="col-xs-9">
                                            <select name="target-page-select" id="target-page-select" class="form-control">
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group" id="move-copy-question-select">
                                        <label for="target-question-select" class="control-label col-xs-3">Position</label>
                                        <div class="col-xs-9">
                                            <select name="target-question-select" id="target-question-select" class="form-control">
                                            </select>
                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" tabindex="-1" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-facebook submit-btn">Move</button>
            </div>
        </div>
    </div>
</div>