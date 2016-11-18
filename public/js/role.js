$('.dataTable').dataTable({
    order: []
});

checkAll($('#new-read'), $('#new-write'), $('.new-read'), $('.new-write'));

$('.permission').click(function () {
    id = $(this).closest('tr').data('id');
    $.ajax('roles/' +id +'/permissions', {
        beforeSend: function () {
            loadingToast("Getting Role Permissions.");
        },
        type: "GET",
        data: {

        },
        success: function (data) {
            endLoadingToast();
            $('#permission-modal-content').html(data);
            $('#permission-modal').modal('show');
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue'
            });

            //CHECK/UNCHECK ALL
           checkAll($('#check-read'), $('#check-write'), $('.read'), $('.write'));
        },
        error: function (data) {
            console.log(data.responseText);
            errorToast("Ooopss Something Went Wrong!");
        }
    });
});

function checkAll(read, write, readBox, writeBox){
    var checkRead = false;
    read.click(function () {
        checkRead = !checkRead;
        if(checkRead){
            readBox.iCheck('check');
        }else{
            readBox.iCheck('uncheck');
        }
    });

    var checkWrite = false;
    write.click(function () {
        checkWrite = !checkWrite;
        if(checkWrite){
            writeBox.iCheck('check');
        }else{
            writeBox.iCheck('uncheck');
        }
    });
}

$('#save-permission').click(function () {
    disable($(this));
});

$('.edit').click(function () {
    title = $(this).closest('tr').data('title');
    id = $(this).closest('tr').data('id');
    bootbox.dialog({
        title: "Edit User Role Title",
        message: '<div class="form-group">' +
        '<label>Title</label>' +
        '<input type="text" id="edit-title" class="form-control" value="' +title +'">' +
        '</div>',
        buttons: {
            cancel: {
                label: "Cancel",
                className: "btn-default"
            },
            save: {
                label: "Save",
                className: "btn-primary",
                callback: function () {
                    $(this).prop('disabled', true);
                    if($.trim($('#edit-title').val()) != ""){
                        $.ajax('roles/update/' +id ,{
                            beforeSend: function () {
                                loadingToast('Saving Category');
                            },
                            type: "POST",
                            data: {
                                title: $('#edit-title').val()
                            },
                            success: function (data) {
                                location.reload();
                            },
                            error: function (data) {
                                errorToast("Oooppsss Something Went wrong.");
                            }
                        });
                    }else{
                        bootbox.alert("Category Name should not be empty");
                    }
                }
            }
        }
    });
});

$('.delete').click(function () {
    console.log('earl is real');
    form = $(this).parent();
    var submit = function () {
        form.submit();
    }
    deleteConfirmation("User Role? All user with these Role will become a NORMAL USER, Confirm", submit);
});