// Custom Scripts for Array Template //

jQuery(function($) {
    "use strict";

        // get the value of the bottom of the #main element by adding the offset of that element plus its height, set it as a variable
        var mainbottom = $('#main').offset().top;

        // on scroll,
        $(window).on('scroll',function(){

        // we round here to reduce a little workload
        stop = Math.round($(window).scrollTop());
        if (stop > mainbottom) {
            $('.navbar').addClass('past-main');
            $('.navbar').addClass('effect-main')
        } else {
            $('.navbar').removeClass('past-main');
       }

      });


  // Collapse navbar on click

   $(document).on('click.nav','.navbar-collapse.in',function(e) {
    if( $(e.target).is('a') ) {
    $(this).removeClass('in').addClass('collapse');
   }
  });

   function  _componentDatePicker (){
       return;
   }


   /*-----------------------------------
   ----------- Scroll To Top -----------
   ------------------------------------*/

    $(window).on('scroll', function () {
      if ($(this).scrollTop() > 1000) {
          $('#back-top').fadeIn();
      } else {
          $('#back-top').fadeOut();
      }
    });
    // scroll body to 0px on click
    $('#back-top').on('click', function () {
      $('#back-top').tooltip('hide');
      $('body,html').animate({
          scrollTop: 0
      }, 1500);
      return false;
    });


    /*-------- Owl Carousel ---------- */

      $(".review-cards").owlCarousel({
        slideSpeed: 200,
        items: 1,
        singleItem: true,
        autoplay:true,
        autoplayTimeout:2000,
        autoplayHoverPause:true,
        pagination: false,
      });


  /* ------ jQuery for Easing min -- */
  (function($) {
    "use strict"; // Start of use strict

    // Smooth scrolling using jQuery easing
    $('a.js-scroll-trigger[href*="#"]:not([href="#"])').on('click', function () {
      if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        if (target.length) {
          $('html, body').animate({
            scrollTop: (target.offset().top - 54)
          }, 1000, "easeInOutExpo");
          return false;
        }
      }
    });

    // Closes responsive menu when a scroll trigger link is clicked
    $('.js-scroll-trigger').on('click', function() {
      $('.navbar-collapse').collapse('hide');
    });

    // Activate scrollspy to add active class to navbar items on scroll
    $('body').scrollspy({
      target: '#mainNav',
      offset: 54
    });

  })(jQuery); // End of use strict


/* --------- Wow Init ------ */

  new WOW().init();


  /* ----- Counter Up ----- */

$('.counter').counterUp({
		delay: 10,
		time: 1000
});

/*----- Preloader ----- */

    $(window).on('load', function() {
  		setTimeout(function() {
        $('#loading').fadeOut('slow', function() {
        });
      }, 3000);
    });


/*----- Subscription Form ----- */

$(document).ready(function() {
     // jQuery Validation
     $("#chimp-form").validate({
         // if valid, post data via AJAX
         submitHandler: function(form) {
             $.post("assets/php/subscribe.php", { email: $("#chimp-email").val() }, function(data) {
                 $('#response').html(data);
             });
         },
         // all fields are required
         rules: {
             email: {
                 required: true,
                 email: true
             }
         }
     });
 });
});


//  form validation
var _formValidation1 = function() {
  if ($('#contact_form').length > 0) {
      $('#contact_form').parsley().on('field:validated', function() {
      var ok = $('.parsley-error').length === 0;
      $('.bs-callout-info').toggleClass('hidden', !ok);
      $('.bs-callout-warning').toggleClass('hidden', ok);
  });
  }

  $('#contact_form').on('submit', function(e) {
      e.preventDefault();
      $('#submit1').hide();
      $('#submiting1').show();
      $(".ajax_error").remove();
      var submit_url = $('#contact_form').attr('action');
      //Start Ajax
      var formData = new FormData($("#contact_form")[0]);
      $.ajax({
          url: submit_url,
          type: 'POST',
          data: formData,
          contentType: false, // The content type used when sending data to the server.
          cache: false, // To unable request pages to be cached
          processData: false,
          dataType: 'JSON',
          success: function(data) {
            if(data.status == 'danger'){
                 toastr.error(data.message);

                }
          else {
            toastr.success(data.message);
              $('#submit').show();
              $('#submiting').hide();
              if (data.goto) {
                 setTimeout(function(){

                   window.location.href=data.goto;
                 },2500);
              }

              if (data.load) {
                setTimeout(function() {

                    window.location.href = "";
                }, 2500);
            }
          }
          },
          error: function(data) {
              var jsonValue = $.parseJSON(data.responseText);
              const errors = jsonValue.errors;
              if (errors) {
                  var i = 0;
                  $.each(errors, function(key, value) {
                      const first_item = Object.keys(errors)[i]
                      const message = errors[first_item][0];
                      $('#' + first_item).parsley().removeError('required', {
                          updateClass: true
                      });
                      $('#' + first_item).parsley().addError('required', {
                          message: value,
                          updateClass: true
                      });
                      // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                      toastr.error(value);
                      i++;
                  });
              } else {
                toastr.error(jsonValue.message);

              }
              $('#submit').show();
              $('#submiting').hide();
          }
      });
  });
};


//  form validation
var _formValidation = function() {
  if ($('#form').length > 0) {
      $('#form').parsley().on('field:validated', function() {
      var ok = $('.parsley-error').length === 0;
      $('.bs-callout-info').toggleClass('hidden', !ok);
      $('.bs-callout-warning').toggleClass('hidden', ok);
  });
  }

  $('#form').on('submit', function(e) {
      e.preventDefault();
      $('#submit1').hide();
      $('#submiting1').show();
      $(".ajax_error").remove();
      var submit_url = $('#form').attr('action');
      //Start Ajax
      var formData = new FormData($("#form")[0]);
      $.ajax({
          url: submit_url,
          type: 'POST',
          data: formData,
          contentType: false, // The content type used when sending data to the server.
          cache: false, // To unable request pages to be cached
          processData: false,
          dataType: 'JSON',
          success: function(data) {
            if(data.status == 'danger'){
                 toastr.error(data.message);

                }
          else {
            toastr.success(data.message);
              $('#submit').show();
              $('#submiting').hide();
              if (data.goto) {
                 setTimeout(function(){

                   window.location.href=data.goto;
                 },2500);
              }

              if (data.load) {
                setTimeout(function() {

                    window.location.href = "";
                }, 2500);
            }
          }
          },
          error: function(data) {
              var jsonValue = $.parseJSON(data.responseText);
              const errors = jsonValue.errors;
              if (errors) {
                  var i = 0;
                  $.each(errors, function(key, value) {
                      const first_item = Object.keys(errors)[i]
                      const message = errors[first_item][0];
                      $('#' + first_item).parsley().removeError('required', {
                          updateClass: true
                      });
                      $('#' + first_item).parsley().addError('required', {
                          message: value,
                          updateClass: true
                      });
                      // $('#' + first_item).after('<div class="ajax_error" style="color:red">' + value + '</div');
                      toastr.error(value);
                      i++;
                  });
              } else {
                toastr.error(jsonValue.message);

              }
              $('#submit').show();
              $('#submiting').hide();
          }
      });
  });
};
