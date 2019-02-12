(function ($) {
  'use strict';

  function setupVideoGallery(context) {
    var $videoGalleries = $('.ListingView--videos', context);

    $videoGalleries
      .find('.ListingView-video .Field--name-field-video')
      .find('a')
      .addClass('js-swipebox');

    $('.js-swipebox', context).swipebox();
    $('.js-swipebox-title', context).swipebox();
  }

  Drupal.behaviors.demoVideoGallery = {
    attach: function (context, settings) {
      setupVideoGallery(context);
    }
  };

}(jQuery));
