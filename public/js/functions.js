(function () {

    var HeroHeight = $(window).height()-$('header').height();

    $('.slider').css("min-height" , HeroHeight-100 +'px');
    //$('.hero-section .hero-content').css("min-height" , WindowHeight-300);


})();
$(document).ready(function(){
    $(".service_provider").click(function(){
        $("#service_provider").prop("checked", true);
    });
    $(".project_owner").click(function(){
        $("#service_provider").prop("checked", false);
        $("#service_provider2").prop("checked", true);
    });

    if ($("ul.pagination").length > 0) {
        $("ul.pagination").addClass('justify-content-center');
    }



});