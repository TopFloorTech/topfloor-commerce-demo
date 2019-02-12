(function ($) {
  'use strict';

  function setHeaderSpacing() {
    var header = $('.js-fixedHeader');
    var spacing = 0;

    var adminTray = $('#toolbar-item-administration-tray.is-active');
    if ($('body').hasClass('toolbar-horizontal') && adminTray.length > 0) {
      spacing += adminTray.height();
    }

    header.css({'margin-top': spacing});
  }

  Drupal.behaviors.fixedHeader = {
    attach: function (context, settings) {
      if (context === document) {
        $(window).resize(function () {
          setHeaderSpacing();
        });

        $(window).scroll(function () {
          $('.js-fixedHeader').toggleClass('is-fixed', ($(window).scrollTop() > 60));
          setHeaderSpacing();
        });

        setTimeout(function () {
          setHeaderSpacing();
        }, 100);
      }
    }
  };
}(jQuery));
