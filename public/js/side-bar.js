$(document).ready(function () {
    $('#btn_menu').click(function () {
        if ($('.main').hasClass('nav-sm'))
        {
            $('.main').removeClass('nav-sm');
            $('.main').addClass('nav-md');
        } else
        {
            $('.main').removeClass('nav-md');
            $('.main').addClass('nav-sm');
        }
    });
    $('.sidebar').tooltip();
});
