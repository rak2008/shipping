<?php

function inv_shortcodes_icon_shortcode_info(&$shortcodes) {
    $shortcodes['icon'] = array(
        'title' => t('Icon'),
        'description' => t('Create an icon'),
        'process callback' => 'inv_shortcodes_process_icon',
    );
}

function inv_shortcodes_process_icon($attrs, $text) {
    $attributes = shortcode_attrs(array(
        'class' => '',
        'icon' => '',
        'link' => ''
    ), $attrs);

    if ($attributes['link'] != "") {
        return "<a href='".$attributes['link']."'><i class='inv-icon ".$attributes['icon']."'></i>".$text."</a>";
    }
    return "<i class='inv-icon ".$attributes['icon']."'></i>".$text;
}

