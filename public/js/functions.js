(function () {

    var HeroHeight = $(window).height()-$('header').height();

    $('.slider').css("min-height" , HeroHeight-100 +'px');
    //$('.hero-section .hero-content').css("min-height" , WindowHeight-300);


})();
$(document).ready(function(){
    $(".service_provider input").click(function(){
        $("#service_provider").prop("checked", true);
        $("#service_provider2").prop("checked", false);
        $(this).parent().addClass('active');
        $('.project_owner').removeClass('active');
        $('#Type').removeClass('disabled');

    });
    $(".project_owner input").click(function(){
        $("#service_provider").prop("checked", false);
        $("#service_provider2").prop("checked", true);
        $(this).parent().addClass('active');
        $('.service_provider').removeClass('active');
        $('#Type').removeClass('disabled');

    });

    if ($("ul.pagination").length > 0) {
        $("ul.pagination").addClass('justify-content-center');
    }

    $('[data-toggle="tooltip"]').tooltip()


    if ($("#ExperienceBox .alert-danger").length > 0) {
        $("a#openExperienceBox").click();
    }


});