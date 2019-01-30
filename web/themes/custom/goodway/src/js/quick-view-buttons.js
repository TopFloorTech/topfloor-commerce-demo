(function ($) {
  'use strict';

  Drupal.behaviors.quickViewButtons = {
    attach: function (context, settings) {
      $(context).find('.CommerceProduct-quickView').each(function () {
        var $quickView = $(this);
        var $prev = $quickView.prev();

        if (!$prev.hasClass('CommerceProduct-quickViewCover')) {
          $('<div class="CommerceProduct-quickViewCover"></div>').insertBefore($quickView).hide();
        }
      });

      $(context)
        .on('mouseover', '.CommerceProduct-teaserTop', function () {
          $(this).find('.CommerceProduct-quickView').show();
          $(this).find('.CommerceProduct-quickViewCover').show();
        })
        .on('mouseout', '.CommerceProduct-teaserTop', function () {
          $(this).find('.CommerceProduct-quickView').hide();
          $(this).find('.CommerceProduct-quickViewCover').hide();
        });
    }
  };
}(jQuery));
