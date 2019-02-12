(function ($) {
  'use strict';

  function setupFaqAccordion(parentElement, context) {
    var questions = $(parentElement, context).find('.Question');

    questions.find('.Question-content').hide();

    questions.on('click', '.Question-title', function () {
      var question = $(this).parent();

      questions.not(question).removeClass('is-open')
        .find('.Question-content:visible').slideUp()
        .prev('.Question-title').find('.fa').removeClass('fa-minus').addClass('fa-plus');

      question.toggleClass('is-open').find('.Question-content').slideToggle()
        .prev('.Question-title').find('.fa').toggleClass('fa-minus').toggleClass('fa-plus');
    });
  }

  Drupal.behaviors.demoFaqAccordion = {
    attach: function (context, settings) {
      setupFaqAccordion('.RelatedView--faq', context);
      setupFaqAccordion('.ListingView--faq', context);
    }
  };
}(jQuery));
