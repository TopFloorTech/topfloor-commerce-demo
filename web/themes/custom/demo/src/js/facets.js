(function ($) {
  'use strict';

  function moveToOffside(facets) {
    var container = $('.MobileMenu.MobileMenu--right');

    if (facets.closest(container).length === 0) {
      facets
        .detach()
        .appendTo(container);
    }
  }

  function moveToSidebar(facets) {
    var container = $('.PageSection.PageSection--sidebarFirst');

    if (facets.closest(container).length === 0) {
      facets
        .detach()
        .appendTo(container);
    }
  }

  function setupBreakpoints(facets) {
    $(window).bind('enterBreakpoint900', function () {
      moveToSidebar(facets);
    });

    $(window).bind('exitBreakpoint900', function () {
      moveToOffside(facets);
    });
  }

  Drupal.behaviors.demoFacets = {
    attach: function (context, settings) {
      if (context === document) {
        var facets = $('.Region.Region--sidebar_first');

        setupBreakpoints(facets);

        if ($(window).outerWidth() < 900) {
          moveToOffside(facets);
        }

        $(document).on('FacetsViewsAjaxUpdateFacetsView', function (event, href, views_settings) {
          console.log(href);
          console.log(views_settings);
        });
      }

      $('.facets-dropdown').chosen();
    }
  };
}(jQuery));
