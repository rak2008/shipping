<?php

function inv_shortcodes_box_shortcode_info(&$shortcodes) {
    $shortcodes['box'] = array(
        'title' => t('Box'),
        'description' => t('Create a box'),
        'process callback' => 'inv_shortcodes_process_box',
    );
}

function inv_shortcodes_process_box($attrs, $text) {
    $attributes = shortcode_attrs(array(
        'title' => '',
        'border' => 'none',//none,square,circle
        'background' => 'no',
        'align' => 'center',//left,center,right
        'icon' => '',
        'image'=>'',
        'number' => '',
        'class'=>'',
        'link'=>'',
        'readmore'=>''), $attrs
    );
    $classes = $attributes['class'];
    $place_holder = '';

    if ($attributes['icon'] != "") {
        $place_holder = '<i class="' . $attributes['icon'] . '"></i>';
    } else {
        if ($attributes['image'] != "") {
            $place_holder = '<img alt="" src="' . $attributes['image'] . '">';
            $classes = $classes." box-image";
        }
    }

    if ($attributes['link'] != "") {
        $place_holder = "<a href=" . $attributes['link'] . ">" . $place_holder . "</a>";
    }

    $classes = $classes." box-".$attributes['border'];
    $classes = $classes." box-".$attributes['align'];

    if($attributes['background'] == 'yes'){
        $classes = $classes.' box-background';
    }

    $render_array = array(
        '#theme' => 'box',
        '#title' => $attributes['title'],
        '#border' => $attributes['border'],
        '#background' => $attributes['background'],
        '#align' => $attributes['align'],
        '#place_holder' => $place_holder,
        '#class'=> $classes,
        '#link'=> $attributes['link'],
        '#readmore'=> $attributes['readmore'],
        '#content' => $text
    );
    return drupal_render($render_array);
}

function inv_shortcodes_box_theme(&$themes, $path) {
    $themes['box'] = array(
        'template' => 'box',
        'path' => $path . '/templates',
        'variables' => array(
            'title' => '',
            'border' => 'none',
            'background' => 'no',
            'align' => 'center',
            'place_holder' => '',
            'class'=> '',
            'link'=> '',
            'readmore'=> '',
            'content' => ''
        )
    );
}