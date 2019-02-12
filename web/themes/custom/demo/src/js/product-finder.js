(function ($) {
  'use strict';

  function setupProductFinderSlider(parentElement, slidesToShow, context, slidesMedium, slidesLarge, stretchFewer) {
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

    var slick = parent.slick({
      slidesToShow: slidesToShow,
      slidesToScroll: slidesToShow,
      dots: false,
      arrows: true,
      adaptiveHeight: true,
      mobileFirst: true,
      responsive: responsive
    });

    parent.on('breakpoint', function (event, slick, breakpoint) {
      switchToFirstActiveSlide(slick);
    });

    return slick;
  }

  function setupProductFilterClickHandler(context) {
    $('.product-finder-applications-filter', context).each(function () {
      var filterContainer = $(this);
      var productFinderView = filterContainer.siblings('.product-finder-filtered-view').eq(0);
      var exposedForm = productFinderView.find('.views-exposed-form').eq(0);
      var exposedSubmit = exposedForm.find('.form-submit').eq(0);
      var exposedFilter = exposedForm.find('.FormItem--field-applications-target-id .form-select').eq(0);
      var selectedFilter = exposedFilter.val();
      var allItems = filterContainer.find('.product-finder-applications-filter-item');

      filterContainer.on('click', '.product-finder-applications-filter-item', function (event) {
        event.preventDefault();
        var filterItem = $(this);
        var filterLink = filterItem.find('.product-finder-application-filter-item-link').eq(0);
        var filterId = filterLink.attr('data-filter-id');

        productFinderView = filterContainer.siblings('.product-finder-filtered-view').eq(0);
        exposedForm = productFinderView.find('.views-exposed-form').eq(0);
        exposedSubmit = exposedForm.find('.form-submit').eq(0);
        exposedFilter = exposedForm.find('.FormItem--field-applications-target-id .form-select').eq(0);

        exposedFilter.val(filterId);
        exposedSubmit.trigger('click');
        allItems.not(filterItem).removeClass('is-active');
        filterItem.addClass('is-active');
      });

      if (selectedFilter !== 'All') {
        allItems.has('[data-filter-id="' + selectedFilter + '"]').addClass('is-active');
      }
    });
  }

  function switchToFirstActiveSlide(slider) {
    var firstActive = $('.slick-slide', slider).not('.is-deactivated').first();
    var index = firstActive.attr('data-slick-index');
    var currentSlideIndex = $(slider).slick('slickCurrentSlide');

    if (currentSlideIndex !== index) {
      $(slider).slick('slickGoTo', index);
    }
  }

  function setupAjaxCompleteHandler(context) {
    $(context).ajaxComplete(function(event, xhr, settings) {
      if (settings.data && settings.data.indexOf('field_applications_target_id') === 0) {
        var filteredRows = $('.product-finder-filtered-view .view-content .views-row', context);
        var slider = $('.view-product-finder-unfiltered .view-content');
        var unfilteredRows = slider.find('.views-row');
        var firstValidResult = null;

        unfilteredRows.each(function () {
          var row = $(this);
          var productId = $(this).find('.CommerceProduct')[0].className.match(/CommerceProduct--id-(\d+)/)[1];
          var isActive = ($(filteredRows).find('.CommerceProduct--id-' + productId).length > 0);

          row.toggleClass('is-deactivated', !isActive);

          if (isActive && !firstValidResult) {
            firstValidResult = row;
          }
        });

        switchToFirstActiveSlide(slider);
      }
    });
  }

  Drupal.behaviors.productFinder = {
    attach: function (context, settings) {
      var oneSidebar = $('body').hasClass('one-sidebar');
      var twoSidebars = $('body').hasClass('two-sidebars')

      var slidesSmall = 1;
      var slidesMedium = 2;
      var slidesLarge = 4;

      if (oneSidebar) {
        slidesLarge = 3;
      } else if (twoSidebars) {
        slidesLarge = 2;
      }

      setupProductFinderSlider('.view-product-finder-unfiltered .view-content', slidesSmall, context, slidesMedium, slidesLarge);
      setupProductFilterClickHandler(context);
      setupAjaxCompleteHandler(context);
    }
  };
}(jQuery));
