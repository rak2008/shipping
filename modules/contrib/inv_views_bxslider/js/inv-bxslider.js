(function($){
	// Responsive Slideshow v1.1
	Drupal.behaviors.inv_bxslider = {
		attach: function(context,settings) {
            $('.inv-bxslider').each(function(index){
            var $this = $(this),
            responsiveID = $(this).attr('id'),
            bxready = $this.data('bx-ready');
            if (bxready == 1) return;
            settings.invbxsliders[responsiveID].total = $('.bxslide',$this).length;
            var options = bxAdjustOptions(settings.invbxsliders[responsiveID], $(this).innerWidth());
            var slide = $(this).bxSlider(options);
            $this.data({
                'bx-ready': 1
            });

            var windowW = $(window).width();
            $(window).resize(function () {
              waitForFinalEvent(function () {
                  if (windowW == $(window).width()) return;
                  windowW = $(window).width();
                  slide.destroySlider();
                  options = bxAdjustOptions(settings.invbxsliders[responsiveID], $this.innerWidth());
                  slide = $this.bxSlider(options);
              }, 500, responsiveID)
              })
			});
		}
	};
	
	/*Adjust bxslider options to fix on any screen*/
	function bxAdjustOptions(options, container_width){
        var _options = {};
		$.extend(_options, options);
		var wWidth = $(window).width();
        if(wWidth >= 1200){
            _options.maxSlides = _options.minSlides = parseInt(options.lg_items);
        }else if(wWidth > 991 && wWidth < 1200){
            _options.maxSlides = _options.minSlides = parseInt(options.md_items);
        }else if(wWidth > 767 && wWidth < 992){
            _options.maxSlides = _options.minSlides = parseInt(options.sm_items);
        }else{
            _options.maxSlides = _options.minSlides = parseInt(options.xs_items);
        }
        if(_options.maxSlides > _options.total){
            _options.maxSlides = _options.minSlides = options.total;
        }
    
        if (options.mode == "horizontal") {
          _options.slideWidth = (container_width - (_options.slideMargin * (_options.maxSlides - 1))) / _options.maxSlides;
        }
        return _options;
	 }
    //
	var waitForFinalEvent = (function () {
        var d = {};
        return function (a, b, c) {
          if (!c) {
            c = "Don't call this twice without a uniqueId"
          }
          if (d[c]) {
            clearTimeout(d[c]);
          }
          d[c] = setTimeout(a, b);
        }
    })();
})(jQuery);