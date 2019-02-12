(function ($) {
  'use strict';

  Drupal.behaviors.hideLogoutButton = {
    attach: function (context, settings) {
      $('.Block--menu-utility .Menu-link[data-drupal-link-system-path="user/logout"]', context).remove();
    }
  };
}(jQuery));
