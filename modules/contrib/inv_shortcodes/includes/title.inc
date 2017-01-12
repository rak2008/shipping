<?php
use \Drupal\Component\Utility\Html;
use \Drupal\Core\Render\Markup;

function inv_shortcodes_title_shortcode_info(&$shortcodes) {
    $shortcodes['title'] = array(
        'title' => t('Title'),
        'description' => t('Create a title'),
        'process callback' => 'inv_shortcodes_process_title',
    );
}

function inv_shortcodes_process_title($attrs, $text) {
    $attributes = shortcode_attrs(array(
        'type' => '',
        'class' => '',
        'icon' => '',
    ), $attrs);

    $sub_title = "";
    if (strpos($text, '~')) {
        $title_array = explode('~', $text);
        $main_title = $title_array[0];
        $sub_title = $title_array[1];
    } else {
        $main_title = $text;
    }
    $render_array = array(
        '#theme' => 'title',
        '#class' => $attributes['class'],
        '#icon' =>$attributes['icon'],
        '#main_title' => $main_title,
        '#sub_title' => $sub_title,
        '#type' => $attributes['type'],
    );
    return drupal_render($render_array);
}

function inv_shortcodes_title_theme(&$themes, $path) {
    $themes['title'] = array(
        'template' => 'title',
        'path' => $path . '/templates',
        'pattern' => 'shortcode__',
        'variables' => array(
            'class' => '',
            'icon' => '',
            'main_title' => '',
            'sub_title' => '',
            'type' => '',
        )
    );
}

/**
 * Implements hook_theme_suggestions_HOOK().
 */
function inv_shortcodes_theme_suggestions_title(array $variables) {
    if ($variables['type'] != "") {
        return array('shortcode__title__'.$variables['type']);
    }
}
