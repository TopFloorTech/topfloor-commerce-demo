(function ($) {
  'use strict';

  function setupDropdownLinks(context) {
    $('.AluminumDropdownLinks', context).each(function () {
      var $dropdownLinks = $(this);

      $dropdownLinks.on('click', '.AluminumDropdownLinks-button', function (event) {
        event.preventDefault();

        var $button = $(this);
        var $linkList = $dropdownLinks.find('.AluminumDropdownLinks-list');

        $linkList.toggleClass('is-active');
        $button.toggleClass('is-active');

        if ($linkList.hasClass('is-active')) {
          $(document).on('click.aluminumDropdownLinks', function (event) {
            if (!$(event.target).closest('.AluminumDropdownLinks').length) {
              $linkList.removeClass('is-active');
              $button.removeClass('is-active');

              $(document).off('click.aluminumDropdownLinks');
            }
          });
        }
      });
    });
  }

  Drupal.behaviors.aluminumDropdownLinks = {
    attach: function (context, settings) {
      setupDropdownLinks(context);
    }
  };
}(jQuery));
