(function ($) {
    Drupal.behaviors.inv_parallax = {
        attach: function (context, settings) {
            if ($('.inv-parallax').length > 0 && $(window).width() > 767) {
                $('body').stellar({
                    horizontalScrolling: false,
                    verticalOffset: 0,
                    horizontalOffset: 0,
                    responsive: true,
                    scrollProperty: 'scroll',
                    parallaxElements: false
                });
            }
        }
    };
})(jQuery);