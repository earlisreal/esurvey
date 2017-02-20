$(function () {
    loadingToast('Loading Survey');

    editSurveyTitle();
    publishSurvey();

    //HIDE LOADING TOAST
    endLoadingToast();
});


function editSurveyTitle(){
    $('.survey-title').click(function () {
        $('#survey-title').val($(this).attr('value'));
    });

    $('#survey-title-modal').on('shown.bs.modal', function (event) {
        $('#survey-title').focus();
    });

    $('#save-survey-title').click(function () {
        $.ajax(createUrl,{
            type: 'POST',
            data: {
                action: 'edit_survey_title',
                survey_title: $('#survey-title').val()
            },
            beforeSend: function(){
                loadingToast('Saving Survey Title');
            },
            success: function (data) {
                $('.jq-toast-wrap').remove();

                $('.survey-title').each(function () {
                    $(this).html($('#survey-title').val());
                });

                $('#survey-title-modal').modal('hide');
                successToast('Title Updated');
            },
            error: function(data){
                console.log(data);
                errorToast();
            }
        });
    });
}

function publishSurvey(){
    $('#publish-survey').click(function () {
        bootbox.confirm("Are you sure you want to publish this Survey? You cannot make changes anymore if you proceed.",
        function (result) {
            if(result){
                $('.publish-form').submit();
            }
        });
    });
}