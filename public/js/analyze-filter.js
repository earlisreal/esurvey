$(function () {
    console.log("filtering");
    initializeRemoveFilter();
    setupFilter();
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
    console.log(results);
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
    $.ajax(filterUrl, {
        type: 'POST',
        data: {
            inSummaryTab: inSummaryTab,
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
            if(inSummaryTab){
                initializeCharts();
            }
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


function initializeRemoveFilter() {
    console.log("in summary tab -> " +inSummaryTab);
    $('.remove-filter').click(function () {
        $.ajax(filterUrl, {
            type: 'DELETE',
            data: {
                inSummaryTab: inSummaryTab,
                key: $(this).data('key'),
                id: $(this).data('id'),
                row: $(this).data('row')
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
                if(inSummaryTab){
                    initializeCharts();
                }
                console.log("complete!");
                $('#page-loader').hide();
            }
        });

    });
}