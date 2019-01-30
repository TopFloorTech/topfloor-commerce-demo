(function ($) {
    Drupal.behaviors.accordionTabs = {
        attach: function (context, settings) {
            var tabs = $('.AccordionTabs', context);

            tabs.each(function () {
                $(this)
                    .children('.AccordionTabs-tabContainer').first()
                    .children('.AccordionTabs-tabHeader').addClass('is-active')
                    .next().addClass('is-open');
            });

            tabs.on('click', ' > .AccordionTabs-tabContainer > .AccordionTabs-tabHeader', function (event) {
                var tabHeader = $(this);
                event.preventDefault();

                if (!tabHeader.hasClass('is-active')) {
                    var accordionTabs = tabHeader.closest('.AccordionTabs');

                    accordionTabs.find('.is-open').removeClass('is-open');
                    tabHeader.next().toggleClass('is-open');
                    accordionTabs.find('.is-active').removeClass('is-active');
                    tabHeader.addClass('is-active');
                }
            });
        }
    };
}(jQuery));
