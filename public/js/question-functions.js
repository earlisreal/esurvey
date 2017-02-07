//TODO reset fields when close,save or question type changed


var questionRowIsClicked = false;
var selectedChoiceType;
var choiceCount = 2;
var questionRowCount = 2;

$(function () {
    console.log("test rearl");
    //!!IMPORTANT
    updateQuestionNumbers();
    $(".question-row-container").each(function(){
        adjustQuestionHeight($(this));
    });
    stopQuestionActionPropagation();

    if(published){
        $('[data-toggle=modal]').each(function () {
            // console.log($(this));
            $(this).removeAttr('data-toggle');
            // e.stopPropagation();
        });
    }else{
        addQuestion();
        addRemoveChoice();
        saveQuestion();
        editQuestion();
        deleteQuestion();
        moveQuestion();
        changePage();
    }
});

function stopQuestionActionPropagation(){
    $('.question-actions .btn').click(function (e) {
        e.stopPropagation();
    });
}

$('#question-type-select').on('change',function(){
    toggleAnswerChoices();
});

function addQuestion(){
    //SET PAGE DATA TO MODAL
    $('.add-question').click(function () {
        setupNewQuestion($(this));
        toggleAnswerChoices();
    });

//adding question from dropdown menu
    $('.type-option a').click(function () {
        // console.log($(this).data('question-type'));
        setupNewQuestion($(this));
        setSelectedQuestionType($(this).data('question-type'));
        toggleAnswerChoices();
    });

    $('#add-question-modal').on('shown.bs.modal', function (event) {
        $('#question-title').focus();
        // console.log($('#save-question').data('question-id'));
    });
}



function setupNewQuestion(target){
    if(questionRowIsClicked){
        $('#question-mandatory').iCheck('uncheck');
        $('#question-modal-form')[0].reset();
        choiceCount = 0;
        $('.modal-choice-row').each(function () {
            if(choiceCount++ >= 2){
                $(this).remove();
            }else{
                $(this).find('.modal-choice-label').parent().removeClass('has-error');
            }
        });
        questionRowIsClicked = false;
    }
    $('#save-question').attr('method', 'add');
    showAddQuestionModal(target, target.data('question-number'));
}

//ADDING NEW CHOICE

function addRemoveChoice(){
    //ADDING CHOICE
    $('#add-question-modal .add-choice').click(function(){
        addChoiceRow($(this), true);
    });

    //ADDING QUESTION ROW
    $('#add-question-modal .add-question-row').click(function(){
        addQuestionRow($(this));
    });

//REMOVING CHOICE

    $('#add-question-modal .remove-choice').click(function(){
        if(choiceCount>2){
            $(this).closest('tr').remove();
            --choiceCount;
        }
    });

    //Removeing Question Row
    $('#add-question-modal .remove-question-row').click(function(){
        console.log("row count -> " +questionRowCount);
        if(questionRowCount>1){
            $(this).closest('tr').remove();
            --questionRowCount;
        }
    });

    //AUTO ADDING ON FOCUS ON LAST ROW
    $('.modal-choice-label').last().focusin(function () {
        // addChoiceRow($(this), false);
    });
}

function addChoiceRow(context, focus){
    console.log("dito pumasok");
    row = context.closest('tr');
    rowCopy = row.clone(true);
    // $('.modal-choice-label').off('focusin', '.modal-choice-label', addChoiceRow);
    // rowCopy.focusin(function () {
    //     addChoiceRow($(this), false);
    // });
    choiceLabel = rowCopy.find('.modal-choice-label');
    console.log(choiceLabel);
    choiceLabel.val('');
    console.log(choiceLabel);
    row.after(rowCopy);
    if(focus){
        choiceLabel.focus();
    }
    ++choiceCount;
}

function addQuestionRow(context){
    console.log("dito pumasok");
    row = context.closest('tr');
    rowCopy = row.clone(true);
    // $('.modal-choice-label').off('focusin', '.modal-choice-label', addChoiceRow);
    // rowCopy.focusin(function () {
    //     addChoiceRow($(this), false);
    // });
    rowLabel = rowCopy.find('.modal-row-label');
    console.log(rowLabel);
    rowLabel.val('');
    console.log(rowLabel);
    row.after(rowCopy);
    rowLabel.focus();
    ++questionRowCount;
    console.log("row count -> " +questionRowCount);
}


//SAVING QUESTION
function saveQuestion(){
    $('#save-question').click(function(){
        console.log("eaetl test");
        var saveButton = $(this);
        var hasError = false;

        pageId = $('#selected-page-id').val();
        manipulationMethod = $(this).attr('method');
        questionID = $(this).data('question-id');

        rows = [];
        if(selectedChoiceType.data('type')=='Likert Scale'){
            console.log('Likert Scale');
            $.each($('.modal-row-label'), function () {
                label = $.trim($(this).val());
                rows.push(label);
            });
        }
        // console.log(rows);

        choices = [];
        if(selectedChoiceType.attr('has-choices')==1){
            $.each($('.modal-choice-row'), function () {
                label = $.trim($(this).find('.modal-choice-label').val());
                weight = $.trim($(this).find('.weight').val());
                if(label != ""){
                    choices.push({
                        label: label,
                        weight: weight
                    });
                }
            });

            console.log(choices);

            if(choices.length < 2){
                $('.modal-choice-label').each(function (i, val) {
                    if(i>1){
                        return false;
                    }
                    $(this).parent().addClass('has-error');
                });
                hasError = true;
            }
        }

        hasError = !validateInputs() || hasError;

        if(hasError){
            return false;
        }


        loadingToast("Saving Question...");

        disable(saveButton, true);

        $.ajax(createUrl, {
            type: 'PUT',
            data: {
                manipulation_method: manipulationMethod,
                question_id: questionID,
                question_title: $('#question-title').val(),
                question_type: $('#question-type-select').val(),
                is_mandatory: $('#question-mandatory').prop('checked') ? 1 : 0,
                max_rating: $('#max-rating').val(),
                page_id: pageId,
                choices: choices,
                rows: rows
            },
            success: function (data) {
                disable(saveButton, false);
                // console.log(data);
                page = getPage(pageId);
                var newQuestion;
                if(manipulationMethod == "add"){
                    page.find('.question-container').append(data);
                    initializeForms();
                    newQuestion = page.find('.question-container .question-row-tools').last();

                }else if(manipulationMethod == "edit"){
                    $('#question'+questionID).closest('.question-row-container').replaceWith(data);
                    newQuestion = $('#question'+questionID).closest('.question-row-container').find('.question-row-tools');
                    initializeForms();
                    // adjustQuestionHeight($('#question'+questionID).parent());
                }

                setNewQuestionEvents(newQuestion);

                newQuestion.click(function () {
                    setupEditQuestion($(this));
                    questionRowIsClicked = true;
                });

                updateQuestionNumbers();

                //RESET MODAL
                $('#add-question-modal').modal('hide');
                $('#question-modal-form')[0].reset();
                successToast();
            },
            error: function(data){
                disable(saveButton, false);
                console.log(data.responseText);
                response = $.parseJSON(data.responseText);
                errorToast();
                // if(response.hasOwnProperty('title')){
                //     console.log(response.title);
                // }
            }
        });
    });
}

function setNewQuestionEvents(newQuestion){
    newQuestion.find('.question-actions .btn').click(function (e) {
        e.stopPropagation();
    });
    newQuestion.find('.delete-question').click(function () {
        setupDeleteQuestion($(this));
    });
    newQuestion.find('.move-question, .copy-question').click(function () {
        setupMoveQuestion($(this));
    });
    // setupNewQuestion(newQuestion);
    adjustQuestionHeight(newQuestion.parent());
    scrollTo(newQuestion);
}

function initializeForms(){
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue'
    });

    ratingScale();
}


//EDITING QUESTION
function editQuestion(){
    $('.question-row-tools').click(function(){
        questionRowIsClicked = true;
        questionRow = $(this).parent().find('.question-row');
        setupEditQuestion(questionRow);

        // console.log(questionRowIsClicked);
    });
}

function setupEditQuestion(context) {
    $('.modal-choice-label').each(function () {
        $(this).parent().removeClass('has-error');
    });

    questionRow = context.closest('.question-row-container').find('.question-row');
    if(questionRow.data('has-choices') == 1){
        //COPYING CURRENT CHOICES TO MODAL
        rowChoiceDiv = $('.modal-choice-row').first().clone(true);
        body = $('#modal-choices-table').find('tbody');
        body.html("");
        $.each(questionRow.find($('.choice-label')), function () {
            choice = rowChoiceDiv.clone(true);
            choice.find('.modal-choice-label').val($(this).text());
            choice.find('.weight').val($(this).data('weight'));
            body.append(choice);
        });
    }

    // console.log("add question");
    $('#save-question').attr('method', 'edit');
    $('#save-question').data('question-id', questionRow.data('question-id'));
    showAddQuestionModal(questionRow, questionRow.find('.question-number').text());
    $('#question-title').val(questionRow.find('.question-title').text());
    $('#max-rating').val(questionRow.data('max-rating'));

    if(questionRow.data('is-mandatory')){
        $('#question-mandatory').iCheck('check');
    }else{
        $('#question-mandatory').iCheck('uncheck');
    }

    setSelectedQuestionType(questionRow.data('question-type'));
    toggleAnswerChoices();
}

function setupMoveQuestion(selector){
    $('#move-copy-modal .submit-btn').prop('disabled', false);

    questionRow = selector.closest('.question-row-container').find('.question-row');
    action = selector.data('action');
    if(action == "move_question"){
        $('#move-copy-modal-label').html("Move Question");
        $('#move-copy-modal .submit-btn').html("Move");
    }else{ //replicate
        $('#move-copy-modal-label').html("Replicate Question");
        $('#move-copy-modal .submit-btn').html("Replicate");
    }

    $('#move-copy-modal .submit-btn').data('question-id', questionRow.attr('id'));
    $('#move-copy-modal .submit-btn').data('action', action);

    $('#move-copy-question-select').show();

    $('#target-page-select').html(getPageOptions());
    $('#target-question-select').html(getQuestionOptions($('.page-row').first()));

    $('#move-copy-modal').modal('show');

}

function moveQuestion(){
    $('.move-question, .copy-question').click(function () {
        setupMoveQuestion($(this));
    });

    $('#move-copy-modal .submit-btn').click(function () {
        action = $(this).data('action');

        if (action == "move_question" || action == "copy_question") {

            $(this).prop('disabled', true);

            questionRow = $('#'+$(this).data('question-id'));

            if(action == 'move_question'){
                loadMessage = "Moving Question..";
                successMessage = "Question Successfully Moved!";
            }else{
                loadMessage = "Replicating Question..";
                successMessage = "Question Successfully Replicated!";
            }

            targetPage = $('#target-page-select').val();
            targetQuestion = $('#target-question-select').val();
            position = $('#move-position-select').val();

            // console.log(targetQuestion);

            $.ajax(createUrl, {
                beforeSend: function () {
                    loadingToast(loadMessage);
                },
                type: "POST",
                data: {
                    action: action,
                    question_id: questionRow.data('question-id'),
                    position: position,
                    target_id: targetQuestion,
                    target_page_id: targetPage
                },
                success: function (data) {
                    // console.log(data);
                    if(action == "move_question"){
                        if(targetQuestion != 0){
                            $('#question'+targetQuestion).closest('.question-container').after(questionRow.parent());
                        }else{
                            getPage(targetPage).find('.question-container').prepend(questionRow.parent());
                        }

                        scrollTo(questionRow);
                    }else{//replicate
                        var newQuestion = $($.parseHTML(data));
                        // console.log(newQuestion);
                        // var newQuestion =  questionRow.parent().clone(true);
                        // newQuestion.attr('id', "question" +data);
                        // newQuestion.data('question-id', data);
                        // console.log($('.question-row-container').first());
                        if(targetQuestion != 0){
                            $('#question'+targetQuestion).closest('.question-row-container').after(newQuestion);
                        }else{
                            getPage(targetPage).find('.question-container').prepend(newQuestion);
                        }
                        setNewQuestionEvents(newQuestion.find('.question-row-tools'));
                        newQuestion.find('input').iCheck({
                            checkboxClass: 'icheckbox_square-blue',
                            radioClass: 'iradio_square-blue'
                        });

                        newQuestion.find('.question-row-tools').click(function () {
                            setupEditQuestion($(this));
                            questionRowIsClicked = true;
                        });

                        scrollTo(newQuestion);

                    }

                    updateQuestionNumbers();

                    $('#move-copy-modal').modal('hide');
                    successToast(successMessage);
                },
                error: function (data) {
                    console.log(data.responseText);
                    $('#move-copy-modal .submit-btn').prop('disabled', false);
                    errorToast();
                }
            });
        }
    });
}

function changePage(){
    $('#target-page-select').change(function () {
        $('#target-question-select').html(getQuestionOptions(getPage($(this).val())));
    });
}


function getQuestionOptions(page){
    var options = "<option value='0'>at beginning of page</option>";
    page.find('.question-row').each(function () {
        options += "<option value='" +$(this).data('question-id') +"'>After "
            +$(this).find('.question-title').html()
            + "</option>";
    });

    return options;
}


function deleteQuestion(){
    $('.question-actions .delete-question').click(function () {
        setupDeleteQuestion($(this));
    });
}

function setupDeleteQuestion(context){
    questionID = context.closest('.question-row-container').find('.question-row').data('question-id');
    var callback = function () {
        $.ajax(createUrl, {
            type: 'POST',
            data: {
                action: 'delete_question',
                question_id: questionID
            },
            beforeSend: function(){
                loadingToast('Delete Question');
            },
            success: function (data) {
                successToast("Question Successfully Deleted!");
                console.log(data);
                $('#question'+questionID).parent().remove();
            },
            error: function(data){
                response = $.parseJSON(data.responseText);
                errorToast();
                // if(response.hasOwnProperty('title')){
                //     console.log(response.title);
                // }
            }
        });
    }
    deleteConfirmation("question", callback);
}


function toggleAnswerChoices() {
    selectedChoiceType = $('#question-type-select').find('option:selected', this);
    // console.log(selectedChoiceType.text());
    $('.weight-field').hide();
    $('#row-container').hide();
    $('#max-rating-div').hide();

    if(selectedChoiceType.text() == "Rating Scale"){
        $('#max-rating-div').show();
    }else if(selectedChoiceType.text() == "Likert Scale"){
        $('.weight-field').show();
        $('#row-container').show();

        if(!questionRowIsClicked){
            row = $('.modal-choice-row').last();
            body = row.parent();
            body.html('');
            for(var i = 1; i <= 5; i++){
                rowCopy = row.clone(true);
                // console.log(parseInt(row.find('.weight').val())+1);
                rowCopy.find('.weight').val(i);
                body.append(rowCopy);
            }
            choiceCount = 5;
        }else{
            console.log("Pumasok sa likert scale");
            //COPYING QUESTION ROWS FOR LIKERT SCALE
            rowDiv = $('.modal-question-row').first().clone(true);
            tbody = $('#modal-rows-table').find('tbody');
            tbody.html("");
            $.each(questionRow.find($('.likert-row')), function () {
                console.log($(this).text());
                row = rowDiv.clone(true);
                row.find('.modal-row-label').val($(this).text());
                tbody.append(row);
            });
        }
    }

    if(selectedChoiceType.attr('has-choices')==1){
        $('#choice-container').show();
        // $('#choice-container').collapse('show');
    }else{
        $('#choice-container').hide();
        // $('#choice-container').collapse('hide');
    }
}

function setSelectedQuestionType(id){

    $('#question-type-select option[value=' +id +']').prop('selected', true);
}


function showAddQuestionModal(target, questionNo){
    $('#selected-page-id').val(target.closest('.page-row').data('id'));
    // console.log(target.closest('.page-row').data('id'));
    $('#modal-question-number').html('Q' +questionNo +':');

    //clear the choices
}

function adjustQuestionHeight(container){
    container.height(container.find('.height-adjuster').height());
}


function updateQuestionNumbers(){
    questionNo = 1;
    $('.page-row').each(function(){
        $(this).find('.question-number').each(function(){
            $(this).data('question-number', questionNo);
            $(this).html(questionNo++);
        });
        $(this).find('.add-question').data('question-number', questionNo);
    });

}