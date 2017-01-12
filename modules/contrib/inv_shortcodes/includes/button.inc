<?php

function inv_shortcodes_button_shortcode_info(&$shortcodes) {
    $shortcodes['button'] = array(
        'title' => t('Button'),
        'description' => t('Create a button'),
        'process callback' => 'inv_shortcodes_process_button',
    );
}

function inv_shortcodes_process_button($attrs, $text) {

    $attributes = $attrs = shortcode_attrs(array(
        'class' => '',
        'link' => '#',
        'target' => '',
        'icon' => '',
        'type' => '',
    ), $attrs);
    $render_array = array(
        '#theme' => 'button',
        '#class' => $attributes['class'],
        '#link' => $attributes['link'],
        '#target' => $attributes['target'],
        '#icon' => $attributes['icon'],
        '#type' => $attributes['type'],
        '#content' => $text,
    );
    return drupal_render($render_array);
}

function inv_shortcodes_button_theme(&$themes, $path) {

    $themes['button'] = array(
        'template' => 'button',
        'path' => $path . '/templates',
        'pattern' => 'shortcode__',
        'variables' => array(
            'class' => '',
            'link' => '',
            'target' => '',
            'icon' => '',
            'type' => '',
            'content' => '',
        )
    );
}

/**
 * Implements hook_theme_suggestions_HOOK().
 */
function inv_shortcodes_theme_suggestions_button(array $variables) {
    if ($variables['type'] != "") {
        return array('shortcode__button__'.$variables['type']);
    }
}