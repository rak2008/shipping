<?php

function innovation_preset_settings_form_alter(&$form){

	$theme = innovation_get_theme();
	$presets = $theme->presets;
	if(empty($presets)){
		$presets = array(
			'innovation_presets' => array(
				array(
					'key' => 'preset1',
					'base_color' => '#0072b9',
					'text_color' => '#494949',
					'link_color' => '#027ac6',
					'link_hover_color' => '#027ac6',
					'heading_color' => '#2385c2',
				)
			)
		);
	}else{
		$presets = array(
			'innovation_presets' => $presets,
		);
	}

	$preset_options = array();
	foreach($presets['innovation_presets'] as $k=>$p){
		$p = (array)$p;
		$preset_options[] = $p['key'];
	}

	$form['preset_settings'] = array(
		'#type' => 'details',
		'#title' => t('Color Settings'),
		'#group' => 'innovation_theme_settings',
		'#weight' => 0
	);
	$form['preset_settings']['innovation_presets'] = array(
		'#type' => 'hidden',
		'#default_value' => theme_get_setting('innovation_presets'),
	);
	$form['preset_settings']['innovation_default_preset'] = array(
		'#type' => 'select',
		'#title' => t('Default preset'),
		'#options' => $preset_options,
		'#default_value' => theme_get_setting('innovation_default_preset'),
		'#description' => t('Choose and save to set this preset is default'),
	);
	$form['preset_settings']['innovation_presets_settings'] = array(
		'#type' => 'fieldset',
		'#title' => t('Preset settings'),
		'#collapsible' => TRUE,
		'#collapsed' => TRUE,
	);
	$form['preset_settings']['innovation_presets_settings']['innovation_presets_list'] = array(
		'#type' => 'select',
		'#title' => t('Presets'),
		'#default_value' => $theme->preset,
		'#options' => $preset_options,
	);

	$default_preset = (array)$presets['innovation_presets'][0];
	$form['preset_settings']['innovation_presets_settings']['innovation_preset_key'] = array(
		'#type' => 'textfield',
		'#title' => t('Preset name'),
		'#default_value' => $default_preset['key'],
		'#description' => 'The css file generated based on this name. e.g: style-[preset_name].css',
		'#attributes' => array('data-property'=>'key','class'=>array('preset-option')),
	);
	$form['preset_settings']['innovation_presets_settings']['innovation_base_color'] = array(
		'#type' => 'textfield',
		'#title' => t('Base color'),
		'#default_value' => $default_preset['base_color'],
		'#attributes' => array('data-property'=>'base_color','class'=>array('color','preset-option')),
	);
    $form['preset_settings']['innovation_presets_settings']['innovation_base_color_opposite'] = array(
		'#type' => 'textfield',
		'#title' => t('Opposite Base color'),
		'#default_value' => isset($default_preset['base_color_opposite'])?$default_preset['base_color_opposite']:$default_preset['base_color'],
		'#attributes' => array('data-property'=>'base_color_opposite','class'=>array('color','preset-option')),
	);
	$form['preset_settings']['innovation_presets_settings']['innovation_link_color'] = array(
		'#type' => 'textfield',
		'#title' => t('Link color'),
		'#default_value' => $default_preset['link_color'],
		'#attributes' => array('data-property'=>'link_color','class'=>array('color','preset-option')),
	);
	$form['preset_settings']['innovation_presets_settings']['innovation_link_hover_color'] = array(
		'#type' => 'textfield',
		'#title' => t('Link hover color'),
		'#default_value' => $default_preset['link_hover_color'],
		'#attributes' => array('data-property'=>'link_hover_color','class'=>array('color','preset-option')),
	);
	$form['preset_settings']['innovation_presets_settings']['innovation_text_color'] = array(
		'#type' => 'textfield',
		'#title' => t('Text color'),
		'#default_value' => $default_preset['text_color'],
		'#attributes' => array('data-property'=>'text_color','class'=>array('color','preset-option')),
	);
	$form['preset_settings']['innovation_presets_settings']['innovation_heading_color'] = array(
		'#type' => 'textfield',
		'#title' => t('Headding color'),
		'#default_value' => $default_preset['heading_color'],
		'#attributes' => array('data-property'=>'heading_color','class'=>array('color','preset-option')),
	);
	$form['preset_settings']['innovation_presets_settings']['innovation_link_picker'] = array(
		'#markup' => '<div id="placeholder"></div>',
	);
//	$form['#attached'] = array(
////		'drupalSettings' => $presets,
//		'library' => array('innovation/innovation-farbtastic'),
//	);
	$form['#attached']['drupalSettings'] = array_merge($form['#attached']['drupalSettings'], $presets);
	$form['#attached']['library'][] = 'innovation/innovation-farbtastic';
}
