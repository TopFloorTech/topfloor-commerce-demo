!function(n){"use strict";function i(i){n(".AluminumDropdownLinks",i).each(function(){var i=n(this);i.on("click",".AluminumDropdownLinks-button",function(o){o.preventDefault();var s=n(this),t=i.find(".AluminumDropdownLinks-list");t.toggleClass("is-active"),s.toggleClass("is-active"),t.hasClass("is-active")&&n(document).on("click.aluminumDropdownLinks",function(i){n(i.target).closest(".AluminumDropdownLinks").length||(t.removeClass("is-active"),s.removeClass("is-active"),n(document).off("click.aluminumDropdownLinks"))})})})}Drupal.behaviors.aluminumDropdownLinks={attach:function(n,o){i(n)}}}(jQuery);
//# sourceMappingURL=maps/dropdown-links.js.map
