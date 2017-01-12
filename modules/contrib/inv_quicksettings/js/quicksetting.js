 jQuery(document).ready(function($){
    $('.quicksettings_toggle').click(function(){
      $('#block-quicksettings').toggleClass('open');
    })
    $('select.inv_layout').change(function(){
      $('body').removeClass('boxed wide').addClass($(this).val());
      $(window).trigger('resize');
    });
    if($('body').hasClass('boxed')){
      $('select.inv_layout').val('boxed').trigger('change');
    }else{
      $('select.inv_layout').val('wide').trigger('change');
    }
	$('select.inv_direction').change(function(){
      $('body').removeClass('ltr rtl').addClass($(this).val());
    });
  });