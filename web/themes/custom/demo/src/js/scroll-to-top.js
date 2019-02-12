(function ($) {
  'use strict';

  Drupal.behaviors.scrollToTop = {
    attach: function (context, settings) {
      if (context === document) {
        if ($('.ScrollToTop').length == 0) {
          $('body').prepend($('<a href="javascript:" class="ScrollToTop">').append($('<i class="fa fa-chevron-up">')));
        }

        $(window).scroll(function () {
          if ($(this).scrollTop() >= 80) {
            $('.ScrollToTop').fadeIn(200);
          } else {
            $('.ScrollToTop').fadeOut(200);
          }
        });

        $('.ScrollToTop').click(function () {
          $('body,html').animate({
            scrollTop: 0
          }, 500);
        });
      }
    }
  };
}(jQuery));
