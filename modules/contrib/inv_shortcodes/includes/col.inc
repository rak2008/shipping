<?php

function inv_shortcodes_col_shortcode_info(&$shortcodes) {
    $shortcodes['col'] = array(
        'title' => t('Column'),
        'description' => t('Create a column bootstrap'),
        'process callback' => 'inv_shortcodes_process_col',
    );
}

function inv_shortcodes_process_col($attrs, $text) {
    $attributes = shortcode_attrs(
                array('lg_col'=>'', 'md_col'=>'','sm_col' => '', 'xs_col' => '',
                        'lg_offset_col' => '','md_offset_col' => '', 'sm_offset_col' => '', 'xs_offset_col' => '',
                        'class'=>'',
                    ), $attrs);
    $attrs_col_generated = "";
    if ($attributes['lg_col'] != "") {
        $attrs_col_generated .= " col-lg-".$attributes['lg_col'];
    }
    if ($attributes['md_col'] != "") {
        $attrs_col_generated .= " col-md-".$attributes['md_col'];
    }
    if ($attributes['sm_col'] != "") {
        $attrs_col_generated .= " col-sm-".$attributes['sm_col'];
    }
    if ($attributes['xs_col'] != "") {
        $attrs_col_generated .= " col-xs-".$attributes['xs_col'];
    }
    if ($attributes['lg_offset_col'] != "") {
        $attrs_col_generated .= " col-lg-offset-".$attributes['lg_offset_col'];
    }
    if ($attributes['md_offset_col'] != "") {
        $attrs_col_generated .= " col-md-offset-".$attributes['md_offset_col'];
    }
    if ($attributes['sm_offset_col'] != "") {
        $attrs_col_generated .= " col-md-offset-".$attributes['sm_offset_col'];
    }
    if ($attributes['xs_offset_col'] != "") {
        $attrs_col_generated .= " col-xs-offset-".$attributes['xs_offset_col'];
    }
    if ($attributes['class'] !="") {
        $attrs_col_generated .= " ".$attributes['class'];
    }
    return "<div class='".$attrs_col_generated."'>".$text."</div>";
}