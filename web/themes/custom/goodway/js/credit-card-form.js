!function(r){"use strict";function e(e){r(".credit-card-form",e).not(".credit-card-form--processed").each(function(){var e=r(this),t=r(".credit-card-form__icons",e),i={visa:"4",mastercard:"5",discover:"6",amex:"3"},a=r(".FormItem--payment-information-add-payment-method-payment-details-number, .FormItem--payment-method-payment-details-number",e);t.detach().prependTo(a),a.find(".form-text").on("keyup",function(){var a=r(this),c=a.val().substr(0,1),n=!1;r.each(i,function(r){if(c===i[r])return e.find(".credit-card-form__icon").not(".credit-card-form__icon--"+r).removeClass("is-active"),e.find(".credit-card-form__icon--"+r).addClass("is-active"),n=!0,!1}),n||t.find(".credit-card-form__icon").removeClass("is-active")}).trigger("keyup")})}Drupal.behaviors.creditCardForm={attach:function(r,t){e(r)}}}(jQuery);
//# sourceMappingURL=maps/credit-card-form.js.map