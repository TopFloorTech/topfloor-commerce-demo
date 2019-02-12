(function ($) {
  'use strict';

  function setupRelatedViewSlider(parentElement, slidesToShow, context, slidesMedium, slidesLarge, stretchFewer) {
    slidesMedium = slidesMedium || false;
    slidesLarge = slidesLarge || false;
    stretchFewer = stretchFewer || false;

    var parent = $(parentElement, context);

    if (stretchFewer) {
      var count = parent.children().length;

      if (slidesToShow > count) {
        slidesToShow = count;
      }

      if (slidesMedium && slidesMedium > count) {
        slidesMedium = count;
      }

      if (slidesLarge && slidesLarge > count) {
        slidesLarge = count;
      }
    }

    var responsive = [];

    if (slidesMedium) {
      responsive.push({
        breakpoint: 600,
        settings: {
          slidesToShow: slidesMedium,
          slidesToScroll: slidesMedium
        }
      });
    }

    if (slidesLarge) {
      responsive.push({
        breakpoint: 900,
        settings: {
          slidesToShow: slidesLarge,
          slidesToScroll: slidesLarge
        }
      });
    }

    parent.slick({
      slidesToShow: slidesToShow,
      slidesToScroll: slidesToShow,
      dots: false,
      arrows: true,
      adaptiveHeight: true,
      mobileFirst: true,
      responsive: responsive
    });
  }

  Drupal.behaviors.demoRelatedViewsSliders = {
    attach: function (context, settings) {
      setupRelatedViewSlider('.RelatedView--products:not(.RelatedView--productPage, .RelatedView--sidebar, .RelatedView--tipsTricksAndNews) .view-content', 1, context, 2, 4);
      setupRelatedViewSlider('.RelatedView--products.RelatedView--productPage .view-content', 1, context, 2);
      setupRelatedViewSlider('.RelatedView--industries .view-content', 1, context, 2, false, true);
      setupRelatedViewSlider('.RelatedView--caseStudies .view-content', 1, context, false, 3);
      setupRelatedViewSlider('.RelatedView--articles .view-content', 1, context, false, 2);
      setupRelatedViewSlider('.RelatedView--testimonials .view-content', 1, context);
      setupRelatedViewSlider('.RelatedView--tipsTricksAndNews .view-content', 1, context, false, 2);
      setupRelatedViewSlider('.RelatedView--recommendedAccessories .view-content', 1, context, 2, 3);
      setupRelatedViewSlider('.RelatedView--featuredProducts .view-content', 1, context, 3, 5);
      setupRelatedViewSlider('.RelatedView--featuredCategories .view-content', 1, context, 3, 7);
    }
  };
}(jQuery));
