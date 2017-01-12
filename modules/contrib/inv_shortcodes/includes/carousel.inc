<?php
use \Drupal\Component\Utility\Html;

function inv_shortcodes_carousels_shortcode_info(&$shortcodes) {
    $shortcodes['carousels'] = array(
        'title' => t('Carousels wrapper'),
        'description' => t('Create a carousel wrapper'),
        'process callback' => 'inv_shortcodes_process_carousels',
    );
}

function inv_shortcodes_process_carousels($attrs, $content) {
    $wrapper_id = Html::getId('inv_carousel_'. uniqid());
    global $shortcode_carousel_stack;
	global $thumbnail;
    $total = Count($shortcode_carousel_stack);

    $attributes = shortcode_attrs(
        array('carousel_id' => $wrapper_id,
            'total_item' => $total,
            'pager' => 'control',
            'control' => 'true',
            'auto' => 'true'),
        $attrs);

    $render_array = array(
        '#theme' => 'carousels',
        '#carousel_id' => $attributes['carousel_id'],
        '#total_item' =>  $attributes['total_item'],
        '#pager' => $attributes['pager'],
        '#control' => $attributes['control'],
        '#auto' => $attributes['auto'],
        '#content' =>  $content,
		'#thumbnail' => $thumbnail,
    );
    $shortcode_carousel_stack = null;
    $thumbnail = null;
	return drupal_render($render_array);
}

function inv_shortcodes_carousels_theme(&$themes, $path) {
    $themes['carousels'] = array(
        'template' => 'carousels',
        'path' => $path . '/templates',
        'preprocess functions' => array(
            'template_preprocess',
            'inv_shortcodes_preprocess_shortcode_carousels',
        ),
        'variables' => array(
            'carousel_id' => '',
            'total_item' => 0,
            'pager' => 'control',
            'control' => 'true',
            'auto' => 'true',
            'content' => '',
			'thumbnail' => ''
        )
    );
}

function inv_shortcodes_carousel_shortcode_info(&$shortcodes) {
    $shortcodes['carousel'] = array(
        'title' => t('Carousel item'),
        'description' => t('Create carousel item'),
        'process callback' => 'inv_shortcodes_process_carousel',
    );
}

function inv_shortcodes_process_carousel($attrs, $content) {
    $attributes = shortcode_attrs(
        array('path' => ''), $attrs);
    $path = $attributes['path'];
    if (strpos($attributes['path'], "public://") !== false) {
        $path = file_create_url($path);
    }
    global $shortcode_carousel_stack;
    global $thumbnail;
	if (!is_array($shortcode_carousel_stack)) $shortcode_carousel_stack = array();
    $active = "";
    if (Count($shortcode_carousel_stack) == 0) $active = "active";
    $item = "<div class='item ".$active."'><img alt='' src='".$path."'/>".$content."</div>";
    $shortcode_carousel_stack[] = $item;
	$thumbnail[] = $path;
    return $item;
}