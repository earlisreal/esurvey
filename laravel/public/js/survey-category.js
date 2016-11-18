$('.dataTable').dataTable({
    order: []
});

$('.delete').click(function () {
    form = $(this).parent();
    var submit = function () {
        form.submit();
    }
    deleteConfirmation("Category", submit);
});

$('.edit').click(function () {
    category = $(this).data('category');
    id = $(this).data('id');
    bootbox.dialog({
        title: "Edit Category",
        message: '<div class="form-group">' +
        '<label>Category</label>' +
        '<input type="text" id="edit-category" class="form-control" value="' +category +'">' +
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
                    if($.trim($('#edit-category').val()) != ""){
                        $.ajax('categories/update/' +id ,{
                            beforeSend: function () {
                                loadingToast('Saving Category');
                            },
                            type: "POST",
                            data: {
                              category: $('#edit-category').val()
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
