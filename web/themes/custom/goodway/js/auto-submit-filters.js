!function(t){"use strict";function o(o,u){u.on("change",o,function(){t(".form-submit",u).click()})}Drupal.behaviors.autoSubmitFilters={attach:function(u,s){var i=t(".js-autoSubmit form").not(".js-autoSubmit-processed");o(".form-select",i),i.addClass("js-autoSubmit-processed")}}}(jQuery);
//# sourceMappingURL=maps/auto-submit-filters.js.map
