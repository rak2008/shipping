(function($){
   "use strict";
	//----------> Site Preloader	
	$(window).load(function() {	
		 $('#preloader').fadeOut('slow', function(){
			  $(this).remove();
		 }); 
	});	
	$(document).ready(function() {
	  /* One Page menu */
	  $('.onepage-menu ul').onePageNav();
	  
	  /*Go to top*/
	  $(window).scroll(function () {
		if ($(this).scrollTop() > 100) {
		  $('#go-to-top').css({
			bottom: "10px"
		  });
		} else {
		  $('#go-to-top').css({
			bottom: "-100px"
		  });
		}
	  });
	  $('#go-to-top').click(function () {
		$('html, body').animate({
		  scrollTop: '0px'
		}, 800);
		return false;
	  });	
    /* Tooltips */
    if ($().tooltip) {
        $("[data-toggle='tooltip']").tooltip();
    }
    if ($('#section-page-title .inv-region').hasClass('region-banner')) {
        $('#section-page-title').addClass('has-banner');
    }
	if ($().hoverdir) {
		$('.teaser-style3').each( function() {
			$(this).hoverdir({
				hoverElem : '.portfolio-desc'
			});
		});
	}
	$('.simplenews-subscriber-form i').click(function(){
		$('.simplenews-subscriber-form form').submit();
	});
	$('.search-action').click(function () {
	    $(this).parents('form').submit();
    });
	$('.search-toggle').click(function (e) {
		e.stopPropagation();
		$(this).hide();
	    $(this).parents('.search-block-form').addClass("fullwidth");
    });
	$(document).click(function(e) {
		if(e.target.className !== "form-search"){
			if ($('.search-block-form').hasClass("fullwidth")) {
				$('.search-block-form').removeClass("fullwidth");
				$('.search-toggle').show();
			}
		}
	});
	//----------------------------------> Magnific Popup Lightbox
	if ( $.isFunction($.fn.magnificPopup) ) {
		$('.expand_image').each(function(index, element) {
			$(this).click(function() {		
				$(this).parent().siblings("a").click();
				$(this).parent().siblings(".mf-popup").find(".mf-no-gallery a").click();
				$(this).parent().siblings(".mf-popup").find(".carousel .carousel-inner a:first").click();
				$(this).parent().siblings(".embed-container").find("a").click();
				$(this).parents().siblings(".mf-popup").find(".mf-no-gallery a").click();
				$(this).parents().siblings(".mf-popup").find(".carousel .carousel-inner a:first").click();
				return false;
			});
		});
		$(".magnific-popup, a[data-rel^='magnific-popup'],.mf-no-gallery a").magnificPopup({ 
			type: 'image',
			mainClass: 'mfp-with-zoom', // this class is for CSS animation below
			
			zoom: {
				enabled: true,
				duration: 300,
				easing: 'ease-in-out',
				// The "opener" function should return the element from which popup will be zoomed in
				// and to which popup will be scaled down
				// By defailt it looks for an image tag:
				opener: function(openerElement) {
					// openerElement is the element on which popup was initialized, in this case its <a> tag
					// you don't need to add "opener" option if this code matches your needs, it's defailt one.
					return openerElement.is('img') ? openerElement : openerElement.find('img');
				}
			}

		});
		
		$('.mf-popup').find('.carousel .carousel-inner').once('mfp-processed').each(function() {
			$(this).magnificPopup({
				delegate: 'a',
				type: 'image',
				
				gallery: {
					enabled: true
				},
				removalDelay: 500,
				callbacks: {
					beforeOpen: function() {
						this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
						this.st.mainClass = /*this.st.el.attr('data-effect')*/ "mfp-zoom-in";
					}
				},
				closeOnContentClick: true,
				// allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source
				midClick: true ,	  
				retina: {
					ratio: 1,
					replaceSrc: function(item, ratio) {
					  return item.src.replace(/\.\w+$/, function(m) { return '@2x' + m; });
					} 
				}
			  
			});
		});
		$('.popup-youtube, .popup-vimeo, .popup-gmaps, .vid_con').magnificPopup({
			disableOn:700,
			type:'iframe',
			mainClass:'mfp-fade',
			removalDelay:160,
			preloader:false,
			fixedContentPos:false
		});
		
		$('.ajax-popup-link').magnificPopup({
			type: 'ajax',
			removalDelay: 500,
			mainClass: 'mfp-fade',
			callbacks: {
				beforeOpen: function() {
					this.st.mainClass = "mfp-fade hm_script_loaded";
				},
				parseAjax: function(mfpResponse) {
					
				},
				ajaxContentAdded: function() {
					$(".ajax_content_container").on("click", function(event){
						var target = $(event.target);
						if (target.hasClass("mfp-close")) {
							
						}else{
							event.stopPropagation();
						}
						
					});
					$.getScript('js/functions.js', function( data, textStatus, jqxhr ) { 
						$(".hm_script_loaded .ajax_content_container").css({"opacity" : "1"});
					});
				}
			},
			
		});
		
		$('.popup-with-zoom-anim').magnificPopup({
			type:'inline',
			fixedContentPos:false,
			fixedBgPos:true,
			overflowY:'auto',
			closeBtnInside:true,
			preloader:false,
			midClick:true,
			removalDelay:300,
			mainClass:'my-mfp-zoom-in'
		});
		$('.popup-with-move-anim').magnificPopup({
			type:'inline',
			fixedContentPos:false,
			fixedBgPos:true,
			overflowY:'auto',
			closeBtnInside:true,
			preloader:false,
			midClick:true,
			removalDelay:300,
			mainClass:'my-mfp-slide-bottom'
		});
	}
});
})(window.jQuery);

