var pageNo;

$(function () {
    //!!IMPORTANT
    updatePageNumbers();

    if(published){

    }else{
        addPage();
        savePageTitle();
        editPage();
        deletePage();
        movePage();
    }
});

function getPage(id){
    return $('#page' +id);
}


function addPage(){
    $('.add-page').click(function () {
        disable($('.add-page'), true);
        page = $(this).closest('.page-row');
        $.ajax(createUrl, {
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'add_page',
                page_no: page.data('page-number')
            },
            beforeSend: function(){
                loadingToast('Adding New Page');
            },
            success: function (data) {
                disable($('.add-page'), false);
                console.log(data);
                pageCopy = $('.page-row').first().clone(true);
                pageCopy.data('id', data.id);
                pageCopy.attr('id', 'page' + data.id);
                pageCopy.data('title', "");
                pageCopy.data('description', "");
                pageCopy.find('.edit-page-title').html('<span class="glyphicon glyphicon-plus"></span>Add Page Title');
                pageCopy.find('.page-description').html("");
                pageCopy.find('.question-container').html('');
                page.after(pageCopy);
                pageCopy.scroll();

                //SCROLL TO NEW PAGE
                scrollTo(pageCopy);

                updatePageNumbers();
                successToast('New Page Added!');
            },
            error: function(data){
                console.log(data);
                errorToast();
            }
        });
    });
}

function savePageTitle(){
    $('#save-page-title').click(function () {
        page = getPage($('#selected-page-id').val());
        console.log($("#selected-page-id").val());
        console.log($('#page-title').val());
        console.log($('#page-description').val());
        $.ajax(createUrl, {
            type: 'POST',
            data: {
                action: 'edit_page_title',
                page_id: $("#selected-page-id").val(),
                page_title: $('#page-title').val(),
                page_description: $('#page-description').val()
            },
            beforeSend: function(){
                loadingToast('Saving Page Title');
            },
            success: function (data) {
                $('.jq-toast-wrap').remove();
                console.log(data);
                $('#page-title-modal').modal('hide');
                page.data('title', $('#page-title').val());
                page.data('description', $('#page-description').val());
                page.find($('.edit-page-title')).html($('#page-title').val());
                page.find($('.page-description')).html($('#page-description').val());
                successToast("Page Title Successfully Updated!");
            },
            error: function(data){
                response = $.parseJSON(data.responseText);
                errorToast();
                // if(response.hasOwnProperty('title')){
                //     console.log(response.title);
                // }
            }
        });
    });
}

function editPage(){
    $('.edit-page-description, .edit-page-title, .page-actions .editable').click(function () {
        $('#selected-page-id').val($(this).closest('.page-row').data('id'));
        $('#page-description').val($(this).closest('.page-row').data('description'));
        $('#page-title').val($(this).closest('.page-row').data('title'));
    });

    $('#page-title-modal').on('shown.bs.modal', function (event) {
        target = $(event.relatedTarget);

        page = target.closest('.page-row');

        if(target.data('identifier')=="title"){
            $('#page-title').focus();
        }else{
            $('#page-description').focus();
        }
    });
}

function deletePage(){
    $('.delete-page').click(function () {
        console.log(pageNo);
        if(pageNo <= 2){
            bootbox.alert("You cannot delete the only Page. The Survey must have at least 1 page");
            return false;
        }
        page = $(this).closest('.page-row');

        // console.log(page.data('page-number'));
        // console.log(page.data('id'));
        var confirm = function() {

            $.ajax(createUrl, {
                type: "POST",
                beforeSend: function () {
                    loadingToast("Deleting Page");
                },
                data: {
                    action: "delete_page",
                    page_id: page.data('id'),
                    page_no: page.data('page-number')
                },
                success: function (data) {
                    pageNo--;
                    $('#page'+page.data('id')).remove();
                    updatePageNumbers();
                    updateQuestionNumbers();
                    successToast("Page Successfully Deleted!");
                },
                error: function (data) {
                    console.log(data.responseText);
                    errorToast();
                }
            });
        }
        deleteConfirmation("Are you sure you want to delete this page?", confirm);
    });
}

function movePage(){
    var action;
    $('.move-page, .replicate-page').click(function () {
        console.log('move click');
        $('#move-copy-modal .submit-btn').prop('disabled', false);
        $('#move-copy-question-select').hide();
        sourcePageId = $(this).closest('.page-row').data('id');
        options = getPageOptions();

        $('#target-page-select').html(options);
        action = $(this).data('action');

        if(action == "move_page"){
            $('#move-copy-modal-label').html("Move Page");
            $('#move-copy-modal .submit-btn').html("Move");
        }else{ //replicate
            $('#move-copy-modal-label').html("Replicate Page");
            $('#move-copy-modal .submit-btn').html("Replicate");
        }
    });

    $('#move-copy-modal .submit-btn').click(function () {
        if(action == "move_page" || action == "copy_page"){
            if(action == 'move_question'){
                loadMessage = "Moving Page..";
                successMessage = "Page Successfully Moved!";
            }else{
                loadMessage = "Replicating Page..";
                successMessage = "Page Successfully Replicated!";
            }

            $(this).prop('disabled', true);
            $.ajax(createUrl, {
                beforeSend: function () {
                    loadingToast(loadMessage);
                },
                type: "POST",
                data: {
                    action: action,
                    page_id: sourcePageId,
                    position: $('#move-position-select').val(),
                    target_id: $('#target-page-select').val()
                },
                success: function (data) {
                    console.log(data);
                    if(action == "move_page"){
                        if($('#move-position-select').val() == "below"){
                            getPage($('#target-page-select').val()).after(getPage($('#selected-page-id').val()));
                        }else{ //above
                            getPage($('#target-page-select').val()).before(getPage($('#selected-page-id').val()));
                        }
                    }else{//replicate
                        var newPage = getPage(sourcePageId).clone(true);
                        newPage.attr('id', "page" +data);
                        if($('#move-position-select').val() == "below"){
                            getPage($('#target-page-select').val()).after(newPage);
                        }else{ //above
                            getPage($('#target-page-select').val()).before(newPage);
                        }
                    }
                    updatePageNumbers();
                    updateQuestionNumbers();

                    $('#move-copy-modal').modal('hide');
                    successToast(successMessage);
                },
                error: function (data) {
                    console.log(data.responseText);
                    errorToast();
                }
            });
        }

    });
}


function updatePageNumbers(){
    pageNo = 1;
    $('.page-row').each(function () {
        $(this).data('page-number', pageNo);
        $(this).find('.page-no').html('Page' +pageNo++);
    });
}

function getPageOptions(){
    var options = "";
    $('.page-row').each(function () {
        options += "<option value='" +$(this).data('id') +"'>"
            +$(this).data('page-number') +" "
            +$(this).data('title')
            +"</option>";
    });
    return options;
}