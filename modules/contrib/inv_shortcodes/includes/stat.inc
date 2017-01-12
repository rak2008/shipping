<?php
use \Drupal\Component\Utility\Html;

function inv_shortcodes_stat_shortcode_info(&$shortcodes) {
    $shortcodes['stat'] = array(
        'title' => t('Statistic counter'),
        'description' => t('Create a statistic counter using javascript'),
        'process callback' => 'inv_shortcodes_process_stat',
    );
}

function inv_shortcodes_process_stat($attrs, $text) {
    $attributes = shortcode_attrs(array(
        'title' => '',
        'class' => '',
        'icon' => '',
        'start_number'=>'0',
        'inc_step'=>'1',
        'duration'=>'300', //ms
        'number' => '',
        'content' => ''), $attrs);

    $render_array = array(
        '#theme' => 'stat',
        '#stat_id'=> Html::getId('inv_stat_'. uniqid()),
        '#title' => $attributes['title'],
        '#class' => $attributes['class'],
        '#icon' => $attributes['icon'],
        '#start_number'=>$attributes['start_number'],
        '#inc_step'=>$attributes['inc_step'],
        '#duration'=>$attributes['duration'], //ms
        '#number' => $attributes['number'],
        '#content' => $text,
        '#attached' => array(
            'library' => array('inv_shortcodes/shortcode.stat')
        )
    );
    return drupal_render($render_array);
}

function inv_shortcodes_stat_theme(&$themes, $path) {
    $themes['stat'] = array(
        'template' => 'stat',
        'path' => $path . '/templates',
        'variables' => array(
            'stat_id' => '',
            'title' => '',
            'class' => '',
            'icon' => '',
            'start_number'=>'0',
            'inc_step'=>'1',
            'duration'=>'300', //ms
            'number' => '',
            'content' => ''
        )
    );
}
