(function ($) {
  'use strict';

  function processExternalLinks(context) {
    $('a[href$=".pdf"]', context).attr('target', '_blank');

    $('a', context).each(function() {
      if (location.hostname !== this.hostname && this.hostname.length) {
        $(this).attr('target', '_blank');
      }
    });
  }

  Drupal.behaviors.externalLinks = {
    attach: function (context, settings) {
      processExternalLinks(context);

      $('a[href$="/hvac-blog/"]', context).attr('target', '_blank');
    }
  };
}(jQuery));
