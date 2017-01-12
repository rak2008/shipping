jQuery(document).ready(function($) {
    $(".inv-animate").each(function() {
        var $this = $(this);
        if ($('body').hasClass('mobile')) {
            $this.removeClass('inv-animate');
        } else {
            var animate_class = $this.data('animate'), delay = $this.data('animate-delay') || 0;
            $this.appear(function() {
                setTimeout(function() {
                    $this.addClass('animated').addClass(animate_class);
                }, delay*1000);
            }, {
                accX: 0,
                accY: 0,
                one: true
            });
        }
    });
});
