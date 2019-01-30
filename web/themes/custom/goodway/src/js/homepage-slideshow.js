(function ($) {
  'use strict';

  function setupHomepageSlideshow(context) {
    $('.HomepageSlideshow .view-content', context).slick({
      adaptiveHeight: true,
      autoplay: true,
      autoplaySpeed: 10000,
      dots: true,
      arrows: true
    });
  }

  Drupal.behaviors.goodwayHomepageSlideshow = {
    attach: function (context, settings) {
      setupHomepageSlideshow(context);
    }
  };
}(jQuery));
