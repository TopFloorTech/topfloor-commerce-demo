(function ($) {
  'use strict';

  var offsetStyle;

  function findStickyTopMargin() {
    var tray = $('.toolbar-tray.is-active.toolbar-tray-horizontal');
    var toolbar = $('.toolbar-bar');
    var header = $('.PageSection--header');

    var offset = header.height() + 25;

    if (toolbar.length > 0) {
      offset += toolbar.outerHeight();
    }

    if (tray.length > 0) {
      offset += tray.outerHeight();
    }

    return offset;
  }

  function setStickyCartPosition(cart) {
    var stickyOffset = findStickyTopMargin();

    var newOffsetStyle = $('<style>@media (min-width: 780px) { .js-stickyCartProcessed.js-stuck { top: ' + stickyOffset + 'px; width: ' + cart.parent().width() + 'px !important; } }</style>');

    if (offsetStyle) {
      offsetStyle.replaceWith(newOffsetStyle);
    } else {
      newOffsetStyle.appendTo('head');
    }

    offsetStyle = newOffsetStyle;
  }

  Drupal.behaviors.stickyCart = {
    attach: function (context, settings) {
      var cart = $('.layout-region-checkout-secondary', context).not('.js-stickyCartProcessed');
      var stickyOffset = findStickyTopMargin() + 'px';

      if (cart.length > 0) {
        var sticky = new Waypoint.Sticky({
          element: cart[0],
          stuckClass: 'js-stuck',
          offset: stickyOffset
        });

        cart.addClass('js-stickyCartProcessed');

        $(window).resize(function () {
          setStickyCartPosition(cart);
        });

        setStickyCartPosition(cart);

        setTimeout(function () {
          setStickyCartPosition(cart);
        }, 1000);
      }
    }
  };
}(jQuery));
