$(function () {
    initializeCharts();

    // filterDate();
    $('.datatable').dataTable({
        order: [],
        paging: false,
        searching: false,
        bInfo: false,
        // "lengthChange": false,
        // "ordering": true,
        // "autoWidth": false
    });
});


function filterDate() {
    // console.log(minDate);
    var start = moment(minDate);
    var end = moment();

    var startDate = start;
    var endDate = end;

    if (getUrlParameter('start') != null && getUrlParameter('end') != null) {
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

    cb(start, end);

    $('#filter-btn').on('apply.daterangepicker', function (e, picker) {
        //filter table
        start = picker.startDate;
        end = picker.endDate;

        console.log(window.location.pathname + '?start=' + start.format('YYYY-MM-DD') + '&end=' + end.format('YYYY-MM-DD'));
        // window.location.href +'&start=' +start.format('YYYY-MM-DD') +'&end=' +end.format('YYYY-MM-DD')
        // setGetParameter('start', start.format('YYYY-MM-DD'));
        // setGetParameter('end', end.format('YYYY-MM-DD'));
        window.location.replace(window.location.pathname + '?start=' + start.format('YYYY-MM-DD') + '&end=' + end.format('YYYY-MM-DD'));
    });
}

function initializeCharts() {
    console.log(results);
    for (var i = 1; i <= results.length; i++) {
        var data = results[i - 1]['datas'];
        if (results[i-1]['total'] == "0") {
            $('#chart' + i).html("<h2>No Data Found :(</h2>");
            continue;
        }
        if (results[i - 1]['type'] == 'Likert Scale') {
//                console.log("earl is real");
            var bar_data = {
                data: data,
                color: "#3c8dbc"
            };
            barChart('#chart' + i, [bar_data], results[i - 1]['maxChoiceWeight']);
        } else {
            donutChart('#chart' + i, data);
        }
    }

    function donutChart(context, data) {
        $.plot(context, data, {
            series: {
                pie: {
                    innerRadius: 0.5,
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 1,
                        formatter: labelFormatter,
                        background: {
                            opacity: 0.5,
                            color: '#000'
                        }
                    }
                }
            },
            legend: {
                show: true
            }
        });
    }

    function barChart(context, data, maxWeight) {
        $.plot(context, data, {
            grid: {
                borderWidth: 1,
                borderColor: "#f3f3f3",
                tickColor: "#f3f3f3"
            },
            series: {
                bars: {
                    show: true,
                    barWidth: 0.5,
                    align: "center",
                    horizontal: false
                }
            },
            xaxis: {
                label: "choices",
                mode: "categories",
                tickLength: 0
            },
            yaxis: {
                tickDecimals: 0,
                max: maxWeight
            }
        });
    }

    function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
            + label
            + "<br>"
            + series.percent.toFixed(2) + "%</div>";
    }
}
