$('.dataTable').dataTable({
    order: []
});

$('.edit').click(function () {
    name = $(this).closest('tr').find('.user-name').html();
    id = $(this).closest('tr').data('id');
    $('#user-id').val(id);
    console.log($('#user-id').val());
    $('#user-role').val($(this).data('role-id'));
    console.log($('#user-role').val());
    $('#user-name').html(name);
    $('#role-modal').modal('show');
});