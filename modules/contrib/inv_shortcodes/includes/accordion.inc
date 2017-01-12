<?php
use \Drupal\Component\Utility\Html;
use \Drupal\Core\Render\Markup;

function inv_shortcodes_accordions_shortcode_info(&$shortcodes) {
    $shortcodes['accordions'] = array(
        'title' => t('Accordions wrapper'),
        'description' => t('Create an accordions wrapper'),
        'process callback' => 'inv_shortcodes_process_accordions',
    );
}

function inv_shortcodes_process_accordions($attrs, $content) {
    $wrapper_id = Html::getId('inv_accordions_wrapper_'. uniqid());
    $attributes = shortcode_attrs(array('type'=>'accordion','class' => ''), $attrs);
    $text = "";

    if ($attributes['type'] == "toggle") {
        $text = str_replace('data-parent="#ACCORDION_WRAPPER_ID"', "", $content);
    } else {
        $text = str_replace('ACCORDION_WRAPPER_ID', $wrapper_id, $content);
    }
    $arr = array(
        '#theme' => 'accordions',
        '#accordion_wrapper_id' => $wrapper_id,
        '#type' => $attributes['type'],
        '#class' => $attributes['class'],
        '#content' => ['#markup' => Markup::create($text)],
    );
    return drupal_render($arr);
}

function inv_shortcodes_accordions_theme(&$themes, $path) {

    $themes['accordions'] = array(
        'template' => 'accordions',
        'path' => $path . '/templates',
        'variables' => array(
            'accordion_wrapper_id' => '',
            'type' => '',
            'class' => '',
            'content' => '',
        )
    );
}

function inv_shortcodes_accordion_shortcode_info(&$shortcodes) {
    $shortcodes['accordion'] = array(
        'title' => t('Accordion item'),
        'description' => t('Create an item accordion'),
        'process callback' => 'inv_shortcodes_process_accordion',
    );
}

function inv_shortcodes_process_accordion($attrs, $text) {
    $item_id = Html::getId('inv_accordion_item_'. uniqid());
    $attributes = shortcode_attrs(array('title' => '', 'icon' => '', 'expand' => 'false',), $attrs);
    $item_collapse = 'collapsed';
    $item_active = '';

    if ($attributes['expand'] === "true") {
        $item_active = 'in';
        $item_collapse = '';
    }

    $render_array = array(
        '#theme' => 'accordion',
        '#accordion_item_id' => $item_id,
        '#item_collapse' => $item_collapse,
        '#item_active' => $item_active,
        '#title' => $attributes['title'],
        '#icon' => $attributes['icon'],
        '#content' => ['#markup' => Markup::create($text)],
    );
    return drupal_render($render_array);
}

function inv_shortcodes_accordion_theme(&$themes, $path) {

    $themes['accordion'] = array(
        'template' => 'accordion',
        'path' => $path . '/templates',
        'variables' => array(
            'accordion_item_id' => '',
            'title' => '',
            'icon' => '',
            'expand' => '',
            'item_collapse' => '',
            'item_active' => '',
            'content' => '',
        )
    );
}

