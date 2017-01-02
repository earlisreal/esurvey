$(function () {
    filter();
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

function filter() {
    $('#filter-btn').click(function () {
        $('.filter-dropdown').show();
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

    $('#start-date, #end-date').datepicker({
        autoclose: true,
        format: 'MM d, yyyy'
    });

    $('.cancelBtn').click(function () {
        $(this).closest('.dropdown-menu').hide();
    });

    $('.date-filter > .range_inputs .applyBtn').click(function () {
        var start = moment($('#start-date').val());
        var end = moment($('#end-date').val());
        window.location.replace(window.location.pathname + '?start=' + start.format('YYYY-MM-DD') + '&end=' + end.format('YYYY-MM-DD'));
        $('.date-filter').hide();
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

function showChoices(index) {
    console.log("index -> " +index);
    var question = results[index];
    console.log(question);
    $('#question-label').html("Q" +(parseInt(index) + 1) +": " +question['questionTitle']);
    if (question['type'] == "Multiple Choice") {
        $('.question-filter').hide();
        $('.choices-filter').show();
        var choices = "";
        var datas = question['datas'];
        for(var i = 0; i < datas.length; i++){
            choices += "<div class='checkbox'> " +
                "<label><input type='checkbox' value='" +datas[i]['id'] +"'>" +
                datas[i]['label'] +
                "</label> </div>";
        }
        $('#question-choices').html(choices);

        
    }
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