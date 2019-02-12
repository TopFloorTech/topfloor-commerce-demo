(function ($) {
  'use strict';

  Drupal.behaviors.filterResultsButton = {
    attach: function (context, settings) {
      $(window).scroll(function () {
        $('.Block--filter-results-link', context).toggleClass('is-fixed', ($(window).scrollTop() > 80));
      });
    }
  };
}(jQuery));
