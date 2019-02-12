(function ($) {
    Drupal.behaviors.matchHeights = {
        attach: function (context, settings) {
            $('.js-matchHeightContainer', context).each(function () {
              var $element = $('.js-matchHeight', $(this));
                $element.imagesLoaded(function () {
                  $element.matchHeight();
                });
            });
        }
    }
}(jQuery));
