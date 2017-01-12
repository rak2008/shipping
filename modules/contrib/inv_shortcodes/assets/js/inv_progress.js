jQuery(document).ready(function ($) {
    $(".progress-bar-wrapper").each(function () {
        var percent = $(this).data('percent');
        if (typeof $.fn.appear === 'function') {
            $(this).appear(function () {
                $(this).find('.progress-bar').css({width: percent});
            }, {
                accX: 0,
                accY: 0,
                one: true
            });
        } else {
            $(this).find('.progress-bar').css({width: percent});
        }
    });
});