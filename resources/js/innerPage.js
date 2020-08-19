$(document).ready(function() {
  window.onload = function () {
    $('.loader').fadeOut(500, function(){ $('.loader').remove(); } );
  }

  // var innerPageImg = $('#inner-page-header img.header-bg');
  // $(innerPageImg).parent().css({'background-image' : 'url(' + $(innerPageImg).attr('src') + ')'});
  // $(innerPageImg).remove();

});