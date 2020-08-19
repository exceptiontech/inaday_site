
$(document).ready(function () {
  (function ($) {
    $.fn.menumaker = function (options) {
      var cssmenu = $(this),
        settings = $.extend({
          //title: "",
          format: "dropdown",
          sticky: false
        }, options);

      return this.each(function () {
        cssmenu.prepend('<div id="menu-button">' + settings.title + '</div>');
        $(this).find("#menu-button").on('click', function () {
          $(this).toggleClass('menu-opened');
          var mainmenu = $(this).next('ul');
          if (mainmenu.hasClass('open')) {
            mainmenu.slideToggle().removeClass('open');
          } else {
            mainmenu.slideToggle().addClass('open');
            if (settings.format === "dropdown") {
              mainmenu.find('ul').slideToggle();
            }
          }
        });

        cssmenu.find('li ul').parent().addClass('has-sub');

        multiTg = function () {
          cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
          cssmenu.find('.submenu-button').on('click', function () {
            $(this).toggleClass('submenu-opened');
            if ($(this).siblings('ul').hasClass('open')) {
              $(this).siblings('ul').removeClass('open').slideToggle();
            } else {
              $(this).siblings('ul').addClass('open').slideToggle();
            }
          });
        };

        if (settings.format === 'multitoggle') multiTg();
        else cssmenu.addClass('dropdown');

        if (settings.sticky === true) cssmenu.css('position', 'fixed');

        resizeFix = function () {
          if ($(window).width() > 991) {
            cssmenu.find('ul').show();
          }

          if ($(window).width() <= 991) {
            cssmenu.find('ul').hide().removeClass('open');
          }
        };
        resizeFix();
        return $(window).on('resize', resizeFix);

      });
    };
  })(jQuery);


  (function ($) {
    $(document).ready(function () {

      $("#cssmenu").menumaker({
        title: "",
        format: "multitoggle"
      });

    });
  })(jQuery);

  $('#cssmenu > ul > li > a').click(function () {
    $('#cssmenu > ul > li > a').removeClass("active");
    $(this).addClass("active");
  });

  $('.maplink a').click(function () {
    $('.maplink a').removeClass("active");
    $(this).addClass("active");
  });

  $('.steps  .photo').click(function () {
    $('.steps .photo').removeClass("active");
    $(this).addClass("active");
  });

  $('.pagination li a').click(function () {
    $('.pagination li a').removeClass("active");
    $(this).addClass("active");
  });
  jQuery(window).scroll(function ($) {
    if (jQuery(this).scrollTop() > 85) {
      jQuery('.menu').addClass("sticky");
    } else {
      if (jQuery(this).scrollTop() < 85) {
        jQuery('.menu').removeClass("sticky");
      }
    }
  });

  //Start Item Search Icon

  $(".fas.fa-search.sea-it").click(function () {
    $(".itemsearch").slideDown("");
    $(".fas.fa-search.sea-it").hide("");
    $(".fas.fa-times.cancel").show("");
  });

  $(".fas.fa-times.cancel").click(function () {
    $(".itemsearch").slideUp();
    $(".fas.fa-search.sea-it").show("");
    $(".fas.fa-times.cancel").hide("");
  });

  //End Item Search Icon



  $(window).scroll(function () {
    if ($(this).scrollTop() > 600) {
      $('.scrollToTop').fadeIn();
    } else {
      $('.scrollToTop').fadeOut();
    }
  });
  //Click event to scroll to top
  $('.scrollToTop').click(function () {
    $('html, body').animate({
      scrollTop: 0
    }, 800);
    return false;
  });




  $('a.nav__link[href*="#"]:not([href="#"])').click(function () {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname ==
      this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: target.offset().top
        }, 1000);
        return false;
      }
    }
  });

  $(".vertical").on("click", ".question", function () {
    $(this)
      .toggleClass("active")
      .next()
      .slideToggle();
    $(".answer")
      .not($(this).next())
      .slideUp(300);
    $(this)
      .siblings()
      .removeClass("active");
  });


  $(".btnrating").on('click', (function (e) {

    var previous_value = $("#selected_rating").val();

    var selected_value = $(this).attr("data-attr");
    $("#selected_rating").val(selected_value);

    $(".selected-rating").empty();
    $(".selected-rating").html(selected_value);

    for (i = 1; i <= selected_value; ++i) {
      $("#rating-star-" + i).toggleClass('btn-warning');
      $("#rating-star-" + i).toggleClass('btn-default');
    }

    for (ix = 1; ix <= previous_value; ++ix) {
      $("#rating-star-" + ix).toggleClass('btn-warning');
      $("#rating-star-" + ix).toggleClass('btn-default');
    }
  }));

  $('[data-toggle="tooltip"]').tooltip();

  $(function () {
    // We can attach the `fileselect` event to all file inputs on the page
    jQuery(document).on('change', ':file', function ($) {
      var input = jQuery(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', [numFiles, label]);
    });

    // We can watch for our custom `fileselect` event like this
    jQuery(document).ready(function ($) {
      $(':file').on('fileselect', function (event, numFiles, label) {

        var input = jQuery(this).parents('.input-group').find(':text'),
          log = numFiles > 1 ? numFiles + ' files selected' : label;

        if (input.length) {
          input.val(log);
        } else {
          if (log) alert(log);
        }

      });
    });

  });



  var rangeSlider = function () {
    var slider = $('.range-slider'),
      range = $('.range-slider__range'),
      value = $('.range-slider__value');

    slider.each(function () {

      value.each(function () {
        var value = $(this).prev().attr('value');
        $(this).html(value);
      });

      range.on('input', function () {
        $(this).next(value).html(this.value);
      });
    });
  };

  rangeSlider();


  $(".fas.fa-eye.icon").click(function () {
    $("input.pass").attr("type", "text");
    $(this).hide();
    $(".fas.fa-eye-slash.icon").show();
  });

  $(".fas.fa-eye-slash.icon").click(function () {
    $("input.pass").attr("type", "password");
    $(this).hide();
    $(".fas.fa-eye.icon ").show();
  });

});

//var blank="http://upload.wikimedia.org/wikipedia/commons/c/c0/Blank.gif";
function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $('.img_prev')
        .attr('src', e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
  } else {
    var img = input.value;
    $('.img_prev').attr('src', img);
  }
}