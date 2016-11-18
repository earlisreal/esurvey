<form action="{{ url('admin/roles/'.$role->id .'/permissions') }}" method="POST">
    {{ csrf_field() }}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Set {{ $role->title }} Permissions</h4>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-xs-12" style="margin-top: 10px; ">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Module</td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-default" id="check-read">
                                            <i class="fa fa-btn fa-check-square-o"></i>Read
                                        </button>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-default" id="check-write">
                                            <i class="fa fa-btn fa-check-square-o"></i>Write
                                        </button>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($role->modules as $module)
                                    <tr data-id="{{ $module->id }}">
                                        <td>{{ $module->title }}</td>
                                        <td class="text-center">
                                            <input class="read" type="checkbox" {{ $module->pivot->can_read ? 'checked' : ''}} value="1" name="read{{ $module->pivot->id }}">
                                        </td>
                                        <td class="text-center">
                                            <input class="write" type="checkbox" {{ $module->pivot->can_write ? 'checked' : '' }} value="1" name="write{{ $module->pivot->id }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" tabindex="-1" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <input type="submit" class="btn btn-facebook" id="save-permission" value="Save Changes">
    </div>
</form>