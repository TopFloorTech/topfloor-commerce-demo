(function ($) {
  'use strict';

  function equalizeMenuPanelHeights() {
    $('#block-main-navigation').find('.Menu--main > .Menu-list > .Menu-item').each(function () {
      var $visiblePanels = $(this).find('.Menu-list:visible');

      var visiblePanelHeights = $visiblePanels.map(
        function (a, b) {
          return $(b).height();
        });

      var greatestPanelHeight = Math.max.apply(null, visiblePanelHeights);

      if (greatestPanelHeight < 200) {
        greatestPanelHeight = 200;
      }

      // apply greatest panel height accross menu
      $visiblePanels.each(function (a, b) {
        $(b).height(greatestPanelHeight);
      });
    });
  }

  function setupOffCanvas(container, buttonSelector, side, afterOpen, afterClose) {
    offside(container, {
      slidingElementsSelector: '.viewport, .PageSection--header, .PageSection--responsiveHeader',
      buttonsSelector: buttonSelector,
      slidingSide: (side || 'left'),
      afterOpen: function () {
        if (afterOpen) {
          afterOpen(this);
        }
      },
      afterClose: function () {
        if (afterClose) {
          afterClose(this);
        }
      }
    });

    $('.SiteOverlay').on('click', window.offside.factory.closeOpenOffside);
  }

  function setupOffCanvasMenu(originalMenu, utilityMenu) {
    var offCanvasMenu = originalMenu.clone();
    var $filterButton = $('.Block--filter-results-link .aluminum-link');
    var $myAccountButton = $('.Block--responsive-my-account-pages-link .aluminum-link');

    $filterButton.click(function () {
      event.preventDefault();
    });

    var openedClass = 'fa-times-circle';
    var closedClass = 'fa-bars';
    var $icon = $('.Block--menu-icon').find('.fa');

    setupOffCanvas('#js-mobileMenuLeft', '.Block--menu-icon', 'left', function () {
      $icon.removeClass(closedClass).addClass(openedClass);
    }, function () {
      $icon.removeClass(openedClass).addClass(closedClass);
    });

    setupOffCanvas('#js-mobileMenuRight', '.Block--filter-results-link .aluminum-link', 'right', function () {
      $filterButton.text('Close Filters');
    }, function () {
      $filterButton.text('Filter Results');
    });

    setupOffCanvas('#js-mobileMenuAccount', '.Block--responsive-my-account-pages-link .aluminum-link', 'right', function () {
      $myAccountButton.text('Close Menu');
    }, function () {
      $myAccountButton.text('My Account Pages');
    });

    // add existing utility menu...
    $('.Menu-list', utilityMenu).slicknav({
      prependTo: '.MobileMenu--left',
      allowParentLinks: true,
      label: '',
      closedSymbol: String.fromCharCode('0xf078'),
      openedSymbol: String.fromCharCode('0xf077')
    }).slicknav('open');

    // add existing main menu...
    offCanvasMenu.slicknav({
      prependTo: '.MobileMenu--left',
      allowParentLinks: true,
      label: '',
      closedSymbol: String.fromCharCode('0xf078'),
      openedSymbol: String.fromCharCode('0xf077')
    }).slicknav('open');
  }

  function setupMainMenu(menu) {
    menu
      .addClass('sf-menu')
      .superfish({
        delay: 0,
        cssArrows: false,
        speed: 0,
        disableHI: true,
        onShow: equalizeMenuPanelHeights,
        onHide: equalizeMenuPanelHeights
      });
  }

  Drupal.behaviors.demoMenus = {
    attach: function (context, settings) {
      var mainMenu = $('#block-main-navigation .Menu--main > .Menu-list', context);
      setupOffCanvasMenu(mainMenu, '.Block--menu-utility .Menu--utility');
      setupMainMenu(mainMenu);
    }
  };
}(jQuery));
