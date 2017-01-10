
$3(document).ready(function ($) {
    elmBody = $('body');
    elmBody.on('click', '#btConfirmar', function(){
        var elmForm = $(this).closest('form');
        elmForm.ajaxFormSubmit(function(booStatus){
            var  elmCard = $('.card');
//            strAnimate = 'wobble';
//            strAnimate = 'pulse';
            elmCard.removeClass('fadeInUp');
            elmCard.removeClass('animated');
            if (booStatus) {
                strAnimate = 'fadeOutDown';
            } else {
                strAnimate = 'jello';
            }
            elmCard.addClass(strAnimate);
            elmCard.addClass('animated');
            elmCard.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                elmCard.removeClass(strAnimate);
                elmCard.removeClass('animated');
            });
        });
        return false;
    });
});

function redirect(strUrl)
{
    $('.card').removeClass('fadeInUp');
    $('.card').removeClass('animated');
    strAnimate = 'fadeOutDown';
//            strAnimate = 'jello';
//            strAnimate = 'wobble';
//            strAnimate = 'pulse';
    $('.card').addClass(strAnimate);
    $('.card').addClass('animated');
//            setTimeout(function(){
//                $('.card').removeClass(strAnimate);
//                $('.card').removeClass('animated');
//            }, 1000);
    $('#title').fadeOut();
    $('.card').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        window.location.href = strUrl;
//                $('.card').removeClass(strAnimate);
//                $('.card').removeClass('animated');
    });
}