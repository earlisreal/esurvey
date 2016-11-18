var selectedIndex;

console.log(responseCount);

$(function () {
    dateRange();

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

function dateRange(){
    // var start = moment().subtract(29, 'days');
    var table = $('#response-table').DataTable();

    var start = moment(startDate);
    var end = moment();

    function cb(start, end) {
        $('#current-filter').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#filter-btn').daterangepicker({
        startDate: start,
        endDate: end,
        minDate: start,
        maxDate: end,
        ranges: {
            // 'None': [start, end],
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    // cb(start, end);

    $('#filter-btn').on('apply.daterangepicker', function (e, picker) {
        //filter table
        start = picker.startDate;
        end = picker.endDate;

        table.draw();
    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var minMonth = start.format('MM');
            var minDay = start.format('DD');
            var minYear = start.format('YYYY');

            var maxMonth = end.format('MM');
            var maxDay = end.format('DD');
            var maxYear = end.format('YYYY');

            var date = moment(data[1], 'ddd,MMM DD, YYYY hh:mm A');
            var month = date.format('MM');
            var day = date.format('DD');
            var year = date.format('YYYY');

            if ( minMonth <= month && minDay <= day && minYear <= year &&
                maxMonth >= month && maxDay >= day && maxYear >= year)
            {
                return true;
            }
            return false;
        }
    );
}