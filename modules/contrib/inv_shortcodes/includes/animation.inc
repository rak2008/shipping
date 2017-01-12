<?php

function inv_shortcodes_animation_shortcode_info(&$shortcodes) {
    $shortcodes['animation'] = array(
        'title' => t('Animation'),
        'description' => t('Wrapper this shortcode to do animation inner content'),
        'process callback' => 'inv_shortcodes_process_animation',
    );
}

function inv_shortcodes_process_animation($attrs, $text) {
    $attributes = shortcode_attrs(array(
        'type' => 'fade',
        'delay' => 0,
        ), $attrs
    );
    return '<div class="inv-animate" data-animate-delay="'.$attributes['delay'].'" data-animate="'.$attributes['type'].'">'.$text.'</div>';
}