var selectedIndex;

console.log(responseCount);

$(function () {
    console.log("earl is real from result user ajax");
    // dateRange();

    $('.response-row').click(function () {
        selectedIndex = $(this).index(0);
        showResponseDetails();

        var test = 1;

        console.log($('.response-row:eq(1)').data('response-id'));
    });

    $('.change-selected-index').click(function () {
        selectedIndex = selectedIndex + $(this).data('increment');
        if(selectedIndex < 0) selectedIndex = responseCount-1;
        selectedIndex %= responseCount;
        showResponseDetails();
    });

});

function showResponseDetails(){
    $.ajax({
        url: "",
        dataType: "",
        beforeSend: function () {
            loadingToast("Loading Response Details...");
        },
        type: "POST",
        data: {
            response_id: $('.response-row:eq(' +selectedIndex +')').data('response-id')
        },
        success: function (data) {
            // console.log(data);
            // endLoadingToast();
            closeToast();
            $('#user-response-details').html(data);
            $('#response-details-modal').modal('show');
            $('#response-no').html(selectedIndex+1 +" of " +responseCount);
        },
        error: function (data) {
            console.log(data.responseText);
            errorToast("Server Fail to Respond");
        }
    });
}