(function ($) {
  'use strict';

  function setupAutoSubmitFilter(element, form) {
    form.on('change', element, function () {
      $('.form-submit', form).click();
    });
  }

  Drupal.behaviors.autoSubmitFilters = {
    attach: function (context, settings) {
      var form = $('.js-autoSubmit form').not('.js-autoSubmit-processed');

      setupAutoSubmitFilter('.form-select', form);

      form.addClass('js-autoSubmit-processed');
    }
  };
}(jQuery));
