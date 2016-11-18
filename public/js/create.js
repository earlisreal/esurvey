$(function () {
    console.log('earl is real');
    // $('#from-scratch').collapse('show');
    // $('.panel-heading').on('click', function () {
        // $(this).find('.header-radio').attr('checked', 'checked');
        // showBody();
        // console.log('show');
    // });
});

function showBody(){

    $('.header-radio').each(function () {
        console.log($(this).val());
       if($(this).prop('checked')){
           $(this).closest('.panel').find('.panel-body').collapse('show');
           // $(this).closest('panel-default').find('panel-body').show();
           // $(this).closest('panel-default').show();
       }else{
           $(this).closest('.panel').find('.panel-body').collapse('hide');
           // $(this).closest('panel-default').hide();
           // $(this).closest('panel-default').find('panel-body').hide();
       }
    });
}