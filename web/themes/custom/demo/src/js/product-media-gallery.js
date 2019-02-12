(function ($) {
  'use strict';

  function setupThumbnailSlideshow(mediaGalleries) {
    $(mediaGalleries)
      .find('.ProductMediaGallery-thumbnails')
      .slick({slidesToShow: 4, slidesToScroll: 4});
  }

  function setupProductMediaGallery(context) {
    var $mediaGalleries = $('.ProductMediaGallery', context);

    $mediaGalleries
      .find('.ProductMediaGallery-largeImage, .ProductMediaGallery-thumbnail')
      .find('a')
      .addClass('js-swipebox');

    var thumbHeight = $mediaGalleries.find('.ProductMediaGallery-thumbnails').height();

    if (thumbHeight) {
      setupThumbnailSlideshow($mediaGalleries);
    } else {
      setTimeout(function () {
        setupThumbnailSlideshow($mediaGalleries);
      }, 500);
    }

    $('.js-swipebox', context).swipebox();
  }

  Drupal.behaviors.demoProductMediaGallery = {
    attach: function (context, settings) {
      setupProductMediaGallery(context);
    }
  };
}(jQuery));
