<?php

function inv_shortcodes_flipbox_shortcode_info(&$shortcodes) {
    $shortcodes['flipbox'] = array(
        'title' => t('Flip box'),
        'description' => t('Create an flip box'),
        'process callback' => 'inv_shortcodes_process_flipbox',
    );
}

function inv_shortcodes_process_flipbox($attrs, $text) {
    $attributes = shortcode_attrs(array(
        'icon' => '',
        'image' => '',
        'class' => '',
        'title' => '',
        'content'=> ''
    ), $attrs);
    $render_array = array(
        '#theme' => 'flipbox',
        '#icon' => $attributes['icon'],
        '#image' => $attributes['image'],
        '#class' => $attributes['class'],
        '#title' => $attributes['title'],
        '#content'=> $text
    );
    return drupal_render($render_array);
}

function inv_shortcodes_flipbox_theme(&$themes, $path) {

    $themes['flipbox'] = array(
        'template' => 'flipbox',
        'path' => $path . '/templates',
        'pattern' => 'shortcode__',
        'preprocess functions' => array(
            'template_preprocess',
            'inv_shortcodes_preprocess_shortcode_flipbox',
        ),
        'variables' => array(
            'class' => '',
            'icon' => '',
            'image' => '',
            'title' => '',
            'content' => '',
        )
    );
}

function inv_shortcodes_preprocess_shortcode_flipbox(&$vars) {
    $vars['#attached']['library'] = 'inv_shortcodes/shortcode.flipbox';
}