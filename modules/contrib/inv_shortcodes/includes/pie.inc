<?php

function inv_shortcodes_pie_shortcode_info(&$shortcodes) {
    $shortcodes['pie'] = array(
        'title' => t('Pie paragraph'),
        'description' => t('Create a Pie paragraph'),
        'process callback' => 'inv_shortcodes_process_pie',
    );
}

function inv_shortcodes_process_pie($attrs, $text) {
    $attributes = $attrs = shortcode_attrs(array(
        'percent' => '',
        'title' => '',
        'class' => '',
        'type' => 'type1',
        'content' => $text,
    ), $attrs);
    $render_array = array(
        '#theme' => 'pie',
        '#percent' => $attributes['percent'],
        '#class' => $attributes['class'],
        '#title' => $attributes['title'],
        '#type' => $attributes['type'],
        '#content' => $text,
        '#attached' => array(
            'library' => array('inv_shortcodes/shortcode.pie')
        )
    );
    return drupal_render($render_array);
}

function inv_shortcodes_pie_theme(&$themes, $path) {
    $themes['pie'] = array(
        'template' => 'pie',
        'path' => $path . '/templates',
        'variables' => array(
            'title' => '',
            'percent' => '',
            'class' => '',
            'type' => '',
            'content' => '',
        )
    );
}

