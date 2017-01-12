<?php

function inv_shortcodes_progress_shortcode_info(&$shortcodes) {
    $shortcodes['progress'] = array(
        'title' => t('Progress Bar'),
        'description' => t('Create a progress bar'),
        'process callback' => 'inv_shortcodes_process_progress',
    );
}

function inv_shortcodes_process_progress($attrs, $text) {
    $attributes = $attrs = shortcode_attrs(array(
        'percent' => '',
        'icon' => '',
        'class' => '',
        'type' => '',
        'content' => $text,
    ), $attrs);
    $render_array = array(
        '#theme' => 'progress',
        '#progress_id' => \Drupal\Component\Utility\Html::getId('inv_progress_bar'.uniqid()),
        '#percent' => $attributes['percent'],
        '#icon' => $attributes['icon'],
        '#class' => $attributes['class'],
        '#type' => $attributes['type'],
        '#content' => $text,
        '#attached' => array(
            'library' => array('inv_shortcodes/shortcode.progress')
        )
    );
    return drupal_render($render_array);
}

function inv_shortcodes_progress_theme(&$themes, $path) {
    $themes['progress'] = array(
        'template' => 'progress',
        'path' => $path . '/templates',
        'pattern' => 'shortcode__',
        'variables' => array(
            'progress_id' => '',
            'percent' => '',
            'icon' => '',
            'class' => '',
            'type' => '',
            'content' => '',
        )
    );
}

/**
 * Implements hook_theme_suggestions_HOOK().
 */
function inv_shortcodes_theme_suggestions_progress(array $variables) {
    if ($variables['type'] != "") {
        return array('shortcode__progress__'.$variables['type']);
    }
}