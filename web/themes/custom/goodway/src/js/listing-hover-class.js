(function ($) {
  'use strict';

  Drupal.behaviors.goodwayListingHoverClass = {
    attach: function (context, settings) {
      $('.Node--display-category-teaser', context).each(function () {
        var item = $(this);

        item.find('.Node-header').on({
          mouseenter: function () {
            item.addClass('is-active');
          },
          mouseleave: function () {
            item.removeClass('is-active');
          }
        });
      });
    }
  };
}(jQuery));
