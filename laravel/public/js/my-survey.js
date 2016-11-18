$(function () {
    $('.dataTable').DataTable({
        "order": []
    });
    $('.delete-survey').click(function () {
        form = $(this).parent();
        var submit = function () {
            form.submit();
        }
        deleteConfirmation("survey", submit);
    });
});