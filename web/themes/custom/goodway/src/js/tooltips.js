(function ($) {
  'use strict';

  Drupal.behaviors.tooltips = {
    attach: function (context, settings) {
      $('.is-tooltip').not('.is-tooltip--processed').each(function () {
        var tooltip = $(this).find('.Tooltip').detach();
        var container = $(this);

        container.addClass('is-tooltip--processed').tooltipster({
          content: tooltip,
          animationDuration: 250,
          delay: 500,
          distance: 2,
          IEmin: 9,
          interactive: true,
          side: 'bottom',
          theme: 'tooltipster-noir',
          trigger: 'custom',
          triggerOpen: {
            mouseenter: true,
            touchstart: true
          },
          triggerClose: {
            click: true,
            mouseleave: true,
            scroll: true,
            originClick: true,
            tap: true
          },
          functionBefore: function (instance, helper) {
            $('.is-tooltip--processed').tooltipster('close');
          }
        });
      });

      $(document).on('click', '.tooltipster-base', function () {
        $('.is-tooltip--processed').tooltipster('close');
      })
    }
  };
}(jQuery));
