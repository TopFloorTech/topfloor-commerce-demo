(function ($) {
  'use strict';

  Drupal.behaviors.equalHeightViews = {
    attach: function (context, settings) {
      var views = $('.view-my-default-account-information, .view-my-recent-order-history, .view-my-recently-registered-products', context);

      views.find('.view-content, .view-footer, .view-empty').matchHeight();
      views.find('.views-field-rendered-entity, .views-field-rendered-entity-1').matchHeight();

      $('.view-product-finder-unfiltered .view-content .views-row', context).matchHeight()
    }
  };

  Drupal.behaviors.goodwayMatchHeights = {
    attach: function (context, settings) {
      $('.PageSection--contentBottom .Block', context).matchHeight();
      $('.Region--after_content .Block', context).matchHeight();
      $('.product-finder-applications-filter .product-finder-applications-filter-item', context).matchHeight();

      $('.js-matchHeightContainer', context).each(function () {
        var $container = $(this);
        $container.imagesLoaded(function () {
          $('.js-matchHeight', $container).matchHeight();
        });
      });
    }
  };
}(jQuery));
