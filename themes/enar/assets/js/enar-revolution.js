jQuery(document).ready(function($) {
    var offset_header = "";	
	get_header_offset();	
	
	function get_header_offset(){		
		offset_header = "";
		if(getScreenWidth() <= 992){
			offset_header = "";
		}else{
			offset_header = "#site_header";
		}
	}
	function getScreenWidth(){
		return document.documentElement.clientWidth || document.body.clientWidth || window.innerWidth;
	}

	if ( $.isFunction($.fn.revolution) ) {
		//-------------------------------> Revolution Slider - Fullwidth
		$('.tp-banner-fullwidth').show().revolution({
				dottedOverlay:"none",
				delay:16000,
				startwidth:1170,
				startheight:700,
				hideThumbs:200,
				hideTimerBar:"off",
				thumbWidth:100,
				thumbHeight:50,
				thumbAmount:5,
				spinned:"spinner4", //"spinner1" , "spinner2", "spinner3" , "spinner4", "spinner5"
				navigationType:"bullet",
				navigationArrows:"solo",
				navigationStyle:"preview4",
				
				touchenabled:"on",
				onHoverStop:"on",
				lazyLoad:"on",
				
				swipe_velocity: 0.7,
				swipe_min_touches: 1,
				swipe_max_touches: 1,
				drag_block_vertical: false,
										
				parallax:"scroll",
				parallaxBgFreeze:"off",
				parallaxLevels:[10,20,30,40,50,60,70,80,90,100],
										
				keyboardNavigation:"off",
				
				navigationHAlign:"center",
				navigationVAlign:"bottom",
				navigationHOffset:0,
				navigationVOffset:20,
	
				soloArrowLeftHalign:"left",
				soloArrowLeftValign:"center",
				soloArrowLeftHOffset:20,
				soloArrowLeftVOffset:0,
	
				soloArrowRightHalign:"right",
				soloArrowRightValign:"center",
				soloArrowRightHOffset:20,
				soloArrowRightVOffset:0,
						
				shadow:0, //0,1,2,3  (0 == no Shadow, 1,2,3 - Different Shadow Types)
				fullWidth:"off",
				fullScreen:"on",
	
				spinner:"spinner4",
				
				stopLoop:"off",
				stopAfterLoops:-1,
				stopAtSlide:-1,
	
				shuffle:"off",
				
				autoHeight:"off",						
				forceFullWidth:"off",						
										
				hideThumbsOnMobile:"off",
				hideNavDelayOnMobile:1500,						
				hideBulletsOnMobile:"off",
				hideArrowsOnMobile:"off",
				hideThumbsUnderResolution:0,
				
				hideSliderAtLimit:0,
				hideCaptionAtLimit:0,
				hideAllCaptionAtLilmit:0,
				startWithSlide:0,
				fullScreenOffsetContainer: ""	
		});
		//-------------------------------> Revolution Slider - Panzoom fullscreen
		$('.tp-banner-panzoom-fullscreen').show().revolution({
				dottedOverlay:"none",
				delay:16000,
				startwidth:1170,
				startheight:700,
				hideThumbs:200,
				
				thumbWidth:100,
				thumbHeight:50,
				thumbAmount:5,
				
				navigationType:"bullet",
				navigationArrows:"solo",
				navigationStyle:"preview4",
				
				touchenabled:"on",
				onHoverStop:"on",
				lazyLoad:"on",
				
				swipe_velocity: 0.7,
				swipe_min_touches: 1,
				swipe_max_touches: 1,
				drag_block_vertical: false,
										
										parallax:"scroll",
				parallaxBgFreeze:"on",
				parallaxLevels:[10,20,30,40,50,60,70,80,90,100],
										
				keyboardNavigation:"off",
				
				navigationHAlign:"center",
				navigationVAlign:"bottom",
				navigationHOffset:0,
				navigationVOffset:20,
	
				soloArrowLeftHalign:"left",
				soloArrowLeftValign:"center",
				soloArrowLeftHOffset:20,
				soloArrowLeftVOffset:0,
	
				soloArrowRightHalign:"right",
				soloArrowRightValign:"center",
				soloArrowRightHOffset:20,
				soloArrowRightVOffset:0,
						
				shadow:0,
				fullWidth:"off",
				fullScreen:"on",
	
				spinner:"spinner4",
				
				stopLoop:"off",
				stopAfterLoops:-1,
				stopAtSlide:-1,
	
				shuffle:"off",
				
				autoHeight:"off",						
				forceFullWidth:"off",						
										
				hideThumbsOnMobile:"off",
				hideNavDelayOnMobile:1500,						
				hideBulletsOnMobile:"off",
				hideArrowsOnMobile:"off",
				hideThumbsUnderResolution:0,
				
				hideSliderAtLimit:0,
				hideCaptionAtLimit:0,
				hideAllCaptionAtLilmit:0,
				startWithSlide:0,
				fullScreenOffsetContainer: offset_header	
		});
	};
});
