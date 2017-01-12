(function ($) {
  Drupal.behaviors.inv_accordion = {
    attach: function (context, settings) {
      $('.accordion-filter').once('accordion-filter').each(function () {
        $(this).find('a').on('click', function (e) {
          e.preventDefault();
          if ($(this).hasClass('active')) return false;

          var $this = $(this),
            filter = $this.data('filter');
          if (filter == '*') {
            $(".panel.panel-default").show();
          } else {
            $(".panel.panel-default").show();
            $('.panel.panel-default').not('.' + filter).fadeOut();
          }
          $(this).parents('.inv-accordion-filter').find('a').removeClass('active');
          $(this).addClass('active');
          try {
            if (filter == '*') {
              window.location.hash = 'all';
            } else {
              window.location.hash = filter;
            }
          } catch (e) {
            console.log(e);
          }
          return false;
        });
        try {
          var url = window.location.href,
            idx = url.indexOf("#"),
            hash = idx != -1 ? url.substring(idx + 1) : "";
          if (hash != "") {
            $('a[data-filter=' + hash + ']').trigger('click');
          }
        } catch (e) {
          console.log(e)
        }
      });
    }
  }
})(jQuery)
