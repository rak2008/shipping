<?php

function inv_shortcodes_embed_shortcode_info(&$shortcodes) {
    $shortcodes['embed'] = array(
        'title' => t('Embed content'),
        'description' => t('Embed a block content by block_id'),
        'process callback' => 'inv_shortcodes_process_embed',
    );
}

function inv_shortcodes_process_embed($attrs, $text) {
    $attributes = shortcode_attrs(array(
        'block_id' => ''), $attrs
    );
    $block = \Drupal\block\Entity\Block::load($attributes['block_id']);
	if ($block != null) {
		$block_content = \Drupal::entityManager()
			->getViewBuilder('block')
			->view($block);

		return drupal_render($block_content);
	}
	return "";
}

