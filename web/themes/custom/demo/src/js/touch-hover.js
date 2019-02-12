(function ($) {
  'use strict';

  var isTouch = false;
  var isTouchTimer;
  var curClass = '';

  function addTouchClass() {
    clearTimeout(isTouchTimer);

    isTouch = true;

    if (curClass !== 'is-touch') {
      curClass = 'is-touch';
      $('body').addClass('is-touch');
    }

    isTouchTimer = setTimeout(function () {
      isTouch = false;
    }, 1000);
  }

  function removeTouchClass() {
    if (!isTouch && curClass === 'is-touch') {
      isTouch = false;
      curClass = '';
      $('body').removeClass('is-touch');
    }
  }

  Drupal.behaviors.touchHover = {
    attach: function (context, settings) {
      if (context === document) {
        document.addEventListener('touchstart', addTouchClass, false);
        document.addEventListener('mouseover', removeTouchClass, false);
      }
    }
  };
}(jQuery));
