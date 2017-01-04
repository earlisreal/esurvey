$(function () {
    initializeCharts();
    initializeRemoveFilter();
    setupFilter();
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

var hidden = true;

function setupFilter() {
    $('#filter-btn').click(function () {
        if (hidden) $('.filter-dropdown').show();
        else $('.filter-dropdown').hide();
        hidden = !hidden;
    });

    $('.filter-dropdown > .ranges > ul > li').click(function () {
        switch ($(this).data('filter')) {
            case "date":
                $('.date-filter').show();
                $('.filter-dropdown').hide();
                break;
            case "question":
                showQuestions();
                break;
            case "user":
                break;
        }
    });

    initializeApply();

    $('#start-date, #end-date').datepicker({
        autoclose: true,
        format: 'MM d, yyyy'
    });

    $('.cancelBtn').click(function () {
        hideDropdown();
    });

    $('.date-filter > .range_inputs .applyBtn').click(function () {
        var start = $('#start-date').val();
        var end = $('#end-date').val();

        filter('date', {start: start, end: end});

        // window.location.replace(window.location.pathname + '?start=' + start.format('YYYY-MM-DD') + '&end=' + end.format('YYYY-MM-DD'));
        hideDropdown();
    });
}

function showQuestions() {
    $('.question-filter').show();
    $('.filter-dropdown').hide();

    var options = "<option value='-1'>Select a Question</option>";
    for (var i = 0; i < results.length; i++) {
        options += "<option value='" + i + "'>Q" + (i + 1) + ": " + results[i]['questionTitle'] + "</option>"
    }
    $('#question-select').html(options);

    $('#question-select').change(function () {
        var index = $(this).val();
        if (index != '-1') {
            showChoices($(this).val());
        }
    });
}

function filter(type, datas) {
    $.ajax({
        type: 'POST',
        data: {
            type: type,
            datas: datas
        },
        beforeSend: function () {
            console.log("sending...");
            $('#page-loader').show();
        },
        success: function (data) {
            $('#results').html(data);
        },
        error: function (data) {
            console.log(data);
            errorToast();
        },
        complete: function () {
            initializeRemoveFilter();
            initializeCharts();
            console.log("complete!");
            $('#page-loader').hide();
        }
    });
}

function showChoices(index) {
    $('#question-rows').hide();
    console.log("index -> " + index);
    var question = results[index];
    // console.log(question);
    $('#question-label').html("Q" + (parseInt(index) + 1) + ": " + question['questionTitle']);
    $('.question-filter').hide();
    $('.choices-filter').show();
    var datas = question['datas'];
    switch (question['type']) {
        case "Checkbox":
        case "Multiple Choice":
            var choices = "";
            for (var i = 0; i < datas.length; i++) {
                choices += "<div class='checkbox'> " +
                    "<label><input class='choice-checkbox' type='checkbox' value='" + datas[i]['id'] + "'>" +
                    datas[i]['label'] +
                    "</label> </div>";
            }
            $('#question-choices').html(choices);
            break;
        case "Rating Scale":
            var choices = "";
            for (var i = 0; i < datas.length; i++) {
                choices += "<div class='checkbox'> " +
                    "<label><input class='choice-checkbox' type='checkbox' value='" + datas[i]['label'] + "'>" +
                    datas[i]['label'] +
                    "</label> </div>";
            }
            $('#question-choices').html(choices);
            break;
        case "Likert Scale":
            $('#question-choices').hide();
            var grid = question['grid'];
            var headers = grid['headers'];
            var rows = grid['rows'];

            var options = "<option value='-1'>Select a Row</option>";
            for (var i = 0; i < rows.length; i++){
                options += "<option value='" +rows[i]['id'] +"'>" +rows[i]['label'] +"</option>";
            }
            $('#question-rows').html(options);
            $('#question-rows').show();

            $('#question-rows').change(function () {
                if($(this).val() != '-1'){
                    $('#question-choices').show();
                }else{
                    $('#question-choices').hide();
                }
            });

            var choices = "";
            for (var i = 0; i < headers.length; i++) {
                choices += "<div class='checkbox'> " +
                    "<label><input class='choice-checkbox' type='checkbox' value='" + headers[i]['id'] + "'>" +
                    headers[i]['label'] +
                    "</label> </div>";
            }
            $('#question-choices').html(choices);
            break;
        case "Textbox":
        case "Text Area":
            $('#question-choices').html("<div class='form-group'><input type='text' placeholder='Contains Keyword'></div>");
            break;
    }

}

function initializeApply() {
    $('.choices-filter > .range_inputs .applyBtn').click(function () {

        var question = results[$('#question-select').val()];
        // console.log(question);

        hideDropdown();

        var selectedChoices = [];
        $('.choice-checkbox:checked').each(function () {
            selectedChoices.push($(this).val());
        });

        var row = $('#question-rows').val();

        if(row == '-1'){
            //NO ROW SELECTED
            return false;
        }

        if(selectedChoices.length < 1){
            return false;
        }

        var data = {
            id: question['id'],
            values: selectedChoices,
            row: row
        };

        filter("question", data);
    });
}

function hideDropdown() {
    $('.dropdown-menu').hide();
    hidden = true;
}

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
            barChart('#chart' + i, [bar_data]);
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

    function barChart(context, data) {
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

function initializeRemoveFilter() {
    $('.remove-filter').click(function () {
        $.ajax({
            type: 'DELETE',
            data: {
                key: $(this).data('key'),
                id: $(this).data('id')
            },
            beforeSend: function () {
                console.log("sending...");
                $('#page-loader').show();
            },
            success: function (data) {
                $('#results').html(data);
            },
            error: function (data) {
                console.log(data);
                errorToast();
            },
            complete: function () {
                initializeCharts();
                console.log("complete!");
                $('#page-loader').hide();
            }
        });

    });
}