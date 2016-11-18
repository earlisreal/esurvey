$(function () {
    $('#url').focus();
    $('#url').select();
});

console.log('target ' + targetInitial);
console.log('multiple ' + multipleInitial);
console.log('date ' + dateInitial);

$('#url').on('focus',function () {
    $(this).select();
});

$('#closing-date').datepicker({
    autoclose: true,
    startDate: '+1d'
});

$('#target-number').focusout(function () {
    if($(this).val() < minTarget){
        $(this).val(minTarget);
    }
});

$('#apply-btn').click(function () {
    console.log($('#multiple-off').prop('checked') ? 0 : 1);
    enableApplyBtn(false);
    $.ajax({
        beforeSend: function () {

        },
        type: "PATCH",
        data: {
            multiple_responses: $('#multiple-off').prop('checked') ? 0 : 1,
            date_close: $('#date-off').prop('checked') ? null : $('#closing-date').val(),
            target_responses: $('#target-off').prop('checked') ? null : $('#target-number').val()
        },
        success: function (data) {
            console.log(data);
            enableApplyBtn(false);
            successToast("Options Successfully Applied!");
        },
        error: function (data) {
            console.log(data.responseText);
            enableApplyBtn(true);
            errorToast("Fail to apply Options");
        }
    });
});

$('#multiple-off, #target-off, #date-off').on('ifChanged', function(event){
    var t = ($('#target-off').prop('checked') ? 0 : 1) != targetInitial;
    var m = ($('#multiple-off').prop('checked') ? 0 : 1) != multipleInitial;
    var d = ($('#date-off').prop('checked') ? 0 : 1) != dateInitial;

    enableApplyBtn(t || m || d);
});


$('#target-off').on('ifChanged', function(event){
    if(($('#target-off').prop('checked'))){
        $('#target-number').hide();
    }else{
        $('#target-number').show();
    }
});

$('#date-off').on('ifChanged', function(event){
    if(($('#date-off').prop('checked'))){
        $('#closing-date-div').hide();
    }else{
        $('#closing-date-div').show();
    }
});

$('#target-number').change(function () {
    enableApplyBtn($(this).val() != initialTarget);
});

$('#closing-date').change(function () {
    enableApplyBtn($(this).val() != initialDate);
});

function enableApplyBtn(apply){
    $('#apply-btn').prop('disabled', !apply);
    if(apply){
        $('#clear-btn').show();
    }else{
        $('#clear-btn').hide();
    }
}

$('#close-open-survey').click(function () {
    if(survey_open){
        bootbox.dialog({
            title: "Edit Custom close Message",
            message: '<div class="form-group">' +
            '<textarea id="closed-message" class="form-control" placeholder="Enter Custom Message..">' +
            'The Survey is Closed. Thank you for visiting eSurvey!' +
            '</textarea>' +
            '</div>',
            buttons: {
                cancel: {
                    label: "Cancel",
                    className: "btn-default"
                },
                close: {
                    label: "Close Survey",
                    className: "btn-danger",
                    callback: function () {
                        $(this).prop('disabled', true);
                        console.log($('#closed-message').val());
                        $.ajax({
                            beforeSend: function () {

                            },
                            type: "POST",
                            data: {
                                open: 0,
                                closed_message: $('#closed-message').val()
                            },
                            success: function (data) {
                                console.log(data);
                                successToast("Survey Closed!");
                                survey_open = false;
                                $('#close-open-survey').html("Open Survey");
                                $('#survey-status').html("Close");
                                $(this).prop('disabled', false);
                            },
                            error: function (data) {
                                console.log(data.responseText);
                                $(this).prop('disabled', false);
                            }
                        });
                    }
                }
            }
        });
    }else{ //closed
        bootbox.confirm("Are you sure you want to Open this Survey?", function (result) {
            if(result){
                $(this).prop('disabled', true);
                $.ajax({
                    beforeSend: function () {

                    },
                    type: "POST",
                    data: {
                        open: 1
                    },
                    success: function (data) {
                        console.log(data);
                        successToast("Survey Successfully Open!");
                        survey_open = true;
                        $('#close-open-survey').html("Close Survey");
                        $('#survey-status').html("Open");
                    },
                    error: function (data) {
                        console.log(data.responseText);
                        $(this).prop('disabled', false);
                    }
                });
            }
        })
    }

});