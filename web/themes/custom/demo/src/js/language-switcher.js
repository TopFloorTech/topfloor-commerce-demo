(function ($) {
  'use strict';

  function setupLanguageSwitcher(selector) {
    $(selector).each(function () {
      var $languageSwitcher = $(this);

      $languageSwitcher.on('click', '.LanguageSwitcher-toggle', function () {
        var $links = $languageSwitcher.find('.LanguageSwitcher-links');

        $links.toggleClass('is-active');

        if ($links.hasClass('is-active')) {
          $(document).on('click.languageSwitcher', function (event) {
            if (!$(event.target).closest(selector).length) {
              $(selector).find('.LanguageSwitcher-links.is-active').removeClass('is-active');

              $(document).off('click.languageSwitcher');
            }
          });
        }
      });
    });
  }

  Drupal.behaviors.demoLanguageSwitcher = {
    attach: function (context, settings) {
      setupLanguageSwitcher($('.LanguageSwitcher', context));
    }
  };
}(jQuery));
