(function ($, Drupal, drupalSettings) {
  Drupal.behaviors.inv_grid_masonry_admin = {
    attach: function (context, settings) {
      var $grid_message = $('<div class="inv-grid-message"><span>Saved</span></div>');
      $grid_message.click(function(){
        $(this).hide();
      });
      $('body').append($grid_message);
      $('.inv-grid.masonry-resize').each(function () {
        var $grid = $(this).find('.inv-grid-inner'),
            view_id = $(this).attr('id'),
            options = settings.invgrid[view_id];
        options.columnHeight = Math.floor(options.columnWidth / options.grid_ratio);
        $grid.find('.inv-grid-item').resizable({
          grid: [parseInt(options.columnWidth) + parseInt(options.grid_margin), parseInt(options.columnHeight) + parseInt(options.grid_margin)],
          autoHide: true,
          start: function () {
            $grid.data('resize', false);
          },
          resize: function () {
            $grid.shuffle('update');
          },
          stop: function (event, ui) {
            $grid.data('resize', true);
            var w = Math.round(ui.size.width / options.columnWidth),
                h = Math.round(ui.size.height / options.columnHeight),
                item = $(ui.element).data('index');
            var url = location.protocol +"//"+ location.host + drupalSettings.path.baseUrl + 'admin/masonry/save/' + view_id + '/' + item + '/' + w + '/' + h;

            $('.inv-grid-message span').text('Saving...');
            $('.inv-grid-message').show();
            $.ajax({
              url: url,
              success: function () {
                $('.inv-grid-message span').text('Saved');
                setTimeout(function(){$('.inv-grid-message').hide();},500);
              }
            });
          }
        });
      });
    }
  }
})(jQuery, Drupal, drupalSettings);