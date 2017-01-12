<?php
use \Drupal\Component\Utility\Html;

function inv_shortcodes_tabs_shortcode_info(&$shortcodes) {
    $shortcodes['tabs'] = array(
        'title' => t('Tabs wrapper'),
        'description' => t('Create a tab wrapper'),
        'process callback' => 'inv_shortcodes_process_tabs',
    );
}

function inv_shortcodes_process_tabs($attrs, $content) {
    $tab_wrapper_id = Html::getId('inv_tab_'. uniqid());
    $attributes = shortcode_attrs(array('class' => '','justified' => ''), $attrs);
    global $shortcode_tabs_stack;
    $justify = "";
    if ($attributes['justified'] == "true") {
        $justify = "nav-justified";
    }
    $output = '<div id="'.$tab_wrapper_id.'" class="inv-tab-wrapper '.$attributes['class'].' clearfix"> <ul class="nav nav-tabs '.$justify.'">';
    $tabCount = 1;
    $xclass = "";
    foreach ($shortcode_tabs_stack as $tab) {
        if ($tabCount == 1) {
            $output .= '<li class="active first"><a href="#'.$tab["id"].'" data-toggle="tab"><i class="tab-icon '.$tab["icon"].'"></i>'.$tab["title"].'</a></li>';
        } else {
            if ($tabCount == Count($shortcode_tabs_stack)) {
                $xclass="last";
            }
            $output .= '<li class="'.$xclass.'"><a href="#'.$tab["id"].'" data-toggle="tab"><i class="tab-icon '.$tab["icon"].'"></i>'.$tab["title"].'</a></li>';
        }
        $tabCount = $tabCount + 1;
    }
    $output .= '</ul>';
    $output .='<div class="tab-content">';

    $tabCount = 1;
    foreach ($shortcode_tabs_stack as $tab) {
        if ($tabCount == 1) {
            $output .= '<div id="'.$tab["id"].'" class="active tab-pane fade in">';
        } else {
            $output .= '<div id="'.$tab["id"].'" class="tab-pane fade in">';
        }
        $tabCount = $tabCount + 1;
        $output .= $tab["contents"]["#markup"].'</div>';
    }
    $output .='</div></div>';
    $shortcode_tabs_stack = null;
    return $output;
}

function inv_shortcodes_tab_shortcode_info(&$shortcodes) {
    $shortcodes['tab'] = array(
        'title' => t('Tab item'),
        'description' => t('Create a item tab'),
        'process callback' => 'inv_shortcodes_process_tab',
    );
}

function inv_shortcodes_process_tab($attrs, $content) {
    $tab_item_id = Html::getId('inv_tab_item_'. rand());
    $attributes = shortcode_attrs(array('title' => '', 'icon' => '',), $attrs);
    global $shortcode_tabs_stack;

    if (!is_array($shortcode_tabs_stack)) $shortcode_tabs_stack = array();
    $tabPane = array(
        'title' => $attributes['title'],
        'icon'  => $attributes['icon'],
        'id'    => $tab_item_id,
        'contents' => array(
            '#markup' => $content,
        ),
        'weight' => count($shortcode_tabs_stack),
    );
    $shortcode_tabs_stack[] = $tabPane;
}

