<?php
use \Drupal\Component\Utility\Html;

function inv_shortcodes_maps_shortcode_info(&$shortcodes) {
    $shortcodes['maps'] = array(
        'title' => t('Map wrapper'),
        'description' => t('Create an map wrapper'),
        'process callback' => 'inv_shortcodes_process_maps',
    );
}

function inv_shortcodes_process_maps($attrs, $text) {
    $attributes = shortcode_attrs(array(
        'class' => '',
        'height' => '400px',
        'type' => 'standard', //gray/color/standard
        'zoom' => '10',
		'key' => 'AIzaSyBDOx3gq6MFyzf6wPblrD5RohWqs8D7Htw'), $attrs);
    $render_array = array(
        '#theme' => 'maps',
        '#class' => $attributes['class'],
        '#type' => $attributes['type'],
        '#zoom' => $attributes['zoom'],
        '#height' => $attributes['height'],
		'#key' => $attributes['key'],
        '#content' => $text
    );
    return drupal_render($render_array);
}

function inv_shortcodes_map_theme(&$themes, $path) {
    $themes['maps'] = array(
        'template' => 'map',
        'path' => $path . '/templates',
        'preprocess functions' => array(
            'template_preprocess',
            'inv_shortcodes_preprocess_shortcode_map',
        ),
        'variables' => array(
            'class' => '',
            'type' => 'standard',
            'zoom' => '10',
            'height' => '400px',
			'key' => '',
            'content' => '',
        )
    );
}

function inv_shortcodes_preprocess_shortcode_map(&$vars) {
    $vars['attributes']['id'] = Html::getId('inv_gmap_shortcode');
    $vars['attributes']['class'][] = Html::getClass('inv_gmap_shortcode');
    $vars['attributes']['style'] = "height:{$vars['height']}";
    $vars['attributes']['data-type'] = $vars['type'];
    $vars['attributes']['data-zoom'] = $vars['zoom'];
    $vars['#attached']['library'] = 'inv_shortcodes/shortcode.map';
}

function inv_shortcodes_map_shortcode_info(&$shortcodes) {
    $shortcodes['map'] = array(
        'title' => t('Map marker'),
        'description' => t('Create an map marker'),
        'process callback' => 'inv_shortcodes_process_map_marker',
    );
}

function inv_shortcodes_process_map_marker($attrs, $text){
    $attrs = shortcode_attrs(array(
        'link' => '',
        'title' => '',
        'image' => '',
        'phone' => '',
        'icon' => '',
        'latitude' => '',
        'longitude' => ''), $attrs);
    return "<div class=\"inv-gmap-marker\" data-link=\"{$attrs['link']}\" data-title=\"{$attrs['title']}\" data-image=\"{$attrs['image']}\" data-phone=\"{$attrs['phone']}\" data-latitude=\"{$attrs['latitude']}\" data-longitude=\"{$attrs['longitude']}\" data-icon=\"{$attrs['icon']}\">{$text}</div>";
}
