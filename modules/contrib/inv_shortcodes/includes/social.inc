<?php

function inv_shortcodes_social_shortcode_info(&$shortcodes) {
    $shortcodes['social'] = array(
        'title' => t('Social Icon'),
        'description' => t('Create a social icon'),
        'process callback' => 'inv_shortcodes_process_social',
    );
}

function inv_shortcodes_process_social($attrs, $text) {
    $attributes = shortcode_attrs(array(
        'class' => '',
        'icon' => '',
        'tooltip' => '',
        'placement' =>'bottom',
        'link' => '#',
		'type' => '',
    ), $attrs);
    $render_array = array(
        '#theme' => 'social',
        '#class' => $attributes['class'], // Social name class
        '#icon' => $attributes['icon'], // font class
        '#tooltip' => $attributes['tooltip'],
        '#placement' => $attributes['placement'], //bottom, top, left, right
        '#link' => $attributes['link'],
		'#type' => $attributes['type'],
        '#content' => $text
    );
    return drupal_render($render_array);
}

function inv_shortcodes_social_theme(&$themes, $path) {
    $themes['social'] = array(
        'template' => 'social',
        'path' => $path . '/templates',
        'variables' => array(
            'class' => '',
            'icon' => '',
            'tooltip' => '',
            'placement' =>'',
            'link' => '',
            'content' => '',
			'type' => '',
        )
    );
}

/**
 * Implements hook_theme_suggestions_HOOK().
 */
function inv_shortcodes_theme_suggestions_social(array $variables) {
    if ($variables['type'] != "") {
        return array('shortcode__social__'.$variables['type']);
    }
}