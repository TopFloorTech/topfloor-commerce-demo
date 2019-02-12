(function ($) {
  'use strict';

  Drupal.behaviors.jobApplicationForm = {
    attach: function (context, settings) {
      $('#edit-field-additional-document', context).find('summary').trigger('click');
    }
  };
}(jQuery));
