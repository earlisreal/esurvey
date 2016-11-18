var toastLoader;

$(function () {
    //  !!!IMPORTANT!!
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //run required functions

    $('[data-toggle="tooltip"]').tooltip()


    $('.main-header .navbar .nav>li>a').each(function () {
        var pathname = window.location.pathname;
        var url = window.location.href;
        if(url == $(this).attr('href')){
            $(this).parent().addClass('active');
            $(this).append('<span class="sr-only">(current)</span>');
        }
    });

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue'
    });
});

function validateInputs(){
    var ok = true;
    $('input').each(function(){
        if($(this).prop("required")){
            if($.trim($(this).val())==""){
                $(this).parent().addClass("has-error");
                ok = false;
            }else{
                $(this).parent().removeClass("has-error");
            }
        }
    });
    return ok;
}

function ratingScale(){
    $('.rating-scale').barrating({
        theme: 'fontawesome-stars',
        // showValues: true,
        showSelectedRating: false,
        emptyValue: '-1'
    });
}

function setGetParameter(paramName, paramValue)
{
    var url = window.location.href;
    var hash = location.hash;
    url = url.replace(hash, '');
    if (url.indexOf(paramName + "=") >= 0)
    {
        var prefix = url.substring(0, url.indexOf(paramName));
        var suffix = url.substring(url.indexOf(paramName));
        suffix = suffix.substring(suffix.indexOf("=") + 1);
        suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
        url = prefix + paramName + "=" + paramValue + suffix;
    }
    else
    {
        if (url.indexOf("?") < 0)
            url += "?" + paramName + "=" + paramValue;
        else
            url += "&" + paramName + "=" + paramValue;
    }
    window.location.href = url + hash;
}

function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
}

function deleteConfirmation(item, callbackFunction){
    bootbox.dialog({
        title: "Are you sure you want to delete this " +item +"?",
        message: 'These action cannot be undone.',
        buttons: {
            cancel:{
                label: 'Cancel',
                className: 'btn-default'
            },
            delete:{
                label: 'DELETE',
                className: 'btn-danger',
                callback: function () {
                    callbackFunction();
                }
            }
        }
    });
}


function loadingToast(message){
    toastLoader = $().toastmessage('showToast', {
        text     : message,
        sticky   : true,
        position : 'bottom-left'
    });

// saving the newly created toast into a variable
    $('.toast-item-image').html('<div class="spinner"> ' +
        '<div class="double-bounce1"></div> ' +
        '<div class="double-bounce2"></div> </div>');
}

function errorToast(message){
    closeToast();
    $.toast({
        heading: 'Oooops! Something Went Wrong!',
        icon: 'error',
        stack: false
    })
}

function successToast(message){
    closeToast();
    $.toast({
        heading: 'Success!',
        text: message,
        icon: 'success',
        stack: false
    });
}

function closeToast(){
    $('.jq-toast-wrap').remove();
    $('.toast-container').remove();
}

function endLoadingToast(){
    $().toastmessage('removeToast', toastLoader);

    // closeToast();
}

function disable(context, b){
    context.prop('disabled', b);
}

function scrollTo(context){
    $('html, body').animate({
        scrollTop: (context.offset().top)
    },500);
}

function isChecked(context){
    return context.prop('checked') ? 1 : 0;
}