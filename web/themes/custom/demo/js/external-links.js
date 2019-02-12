!function(t){"use strict";function a(a){t('a[href$=".pdf"]',a).attr("target","_blank"),t("a",a).each(function(){location.hostname!==this.hostname&&this.hostname.length&&t(this).attr("target","_blank")})}Drupal.behaviors.externalLinks={attach:function(n,e){a(n),t('a[href$="/hvac-blog/"]',n).attr("target","_blank")}}}(jQuery);
//# sourceMappingURL=maps/external-links.js.map
