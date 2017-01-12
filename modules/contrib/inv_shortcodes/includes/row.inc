<?php

function inv_shortcodes_row_shortcode_info(&$shortcodes) {
    $shortcodes['row'] = array(
        'title' => t('Row'),
        'description' => t('Create a row bootstrap'),
        'process callback' => 'inv_shortcodes_process_row',
    );
}

function inv_shortcodes_process_row($attrs, $text) {
    $atributes = shortcode_attrs(array('class'=>'', 'wrapper'=>''), $attrs);
    if ($atributes['wrapper'] != "") {
        return '<div class="'.$atributes['wrapper'].'"><div class="row '.$atributes['class'].'">'.$text.'</div></div>';
    }
    return '<div class="row '.$atributes['class'].'">'.$text.'</div>';
}