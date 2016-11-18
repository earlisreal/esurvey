$(function () {
    // console.log(minDate);
    // console.log('earl is real');
    filterDate();
});

function filterDate(){
    // console.log(minDate);
    var start = moment(minDate);
    var end = moment();

    var startDate = start;
    var endDate = end;

    if(getUrlParameter('start') != null && getUrlParameter('end') != null){
        // console.log('meron');
        startDate = moment(getUrlParameter('start'));
        endDate = moment(getUrlParameter('end'));
        // cb(startDate,endDate);
    }

    // console.log(start);
    // console.log(end);

    function cb(start, end) {
        $('#current-filter').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#filter-btn').daterangepicker({
        startDate: startDate,
        endDate: endDate,
        minDate: start,
        maxDate: end,
        ranges: {
            'None': [start, end],
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

        console.log(window.location.pathname +'?start=' +start.format('YYYY-MM-DD') +'&end=' +end.format('YYYY-MM-DD'));
        // window.location.href +'&start=' +start.format('YYYY-MM-DD') +'&end=' +end.format('YYYY-MM-DD')
        // setGetParameter('start', start.format('YYYY-MM-DD'));
        // setGetParameter('end', end.format('YYYY-MM-DD'));
        window.location.replace(window.location.pathname +'?start=' +start.format('YYYY-MM-DD') +'&end=' +end.format('YYYY-MM-DD'));
    });
}