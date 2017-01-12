<?php
use \Drupal\Component\Utility\Html;

function inv_shortcodes_video_shortcode_info(&$shortcodes) {
    $shortcodes['video'] = array(
        'title' => t('Video'),
        'description' => t('Embeded video from Youtube or Videmo by using shortcode'),
        'process callback' => 'inv_shortcodes_process_video',
    );
}

function inv_shortcodes_process_video($attrs, $text) {
    $attributes = shortcode_attrs(array(
        'type' => 'youtube',
        'ratio' => '1.776',
        'video_id' => '',
        'class' => '',
        'width' => '500',
        'height' => '281'
        ), $attrs
    );
    $render_array = array(
        '#theme' => 'video',
        '#type' => $attributes['type'],
        '#ratio' => $attributes['ratio'],
        '#video_id' => $attributes['video_id'],
        '#class' => $attributes['class'],
        '#width' => $attributes['width'],
        '#height' => $attributes['height']
    );
    return drupal_render($render_array);
}

/**
 * Video theme
 */
function inv_shortcodes_video_theme(&$themes, $path) {
    $themes['video'] = array(
        'template' => 'video',
        'path' => $path . '/templates',
        'pattern' => 'shortcode__',
        'preprocess functions' => array(
            'template_preprocess',
            'inv_shortcodes_preprocess_shortcode_video',
        ),
        'variables' => array(
            'video_id' => '',
            'class' => '',
            'type' => '',
            'width' => '',
            'height' => ''
        )
    );
}

function inv_shortcodes_preprocess_shortcode_video(&$vars) {
    $type = $vars['type'];
    $video_id = $vars['video_id'];
    $vars['html_id'] = Html::getId('inv_shortcode_video_' .uniqid());

    if ($type == 'youtube') {
        $vars['url'] = "https://www.youtube.com/embed/{$video_id}";
    } else {
        $vars['url'] = "http://player.vimeo.com/video/{$video_id}";
    }
}