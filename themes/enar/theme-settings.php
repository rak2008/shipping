<?php

function enar_form_system_theme_settings_alter(&$form, &$form_state){
	$form['enar_settings'] = array(
      '#type' => 'details',
      '#title' => t('Enar Settings'),
      '#group' => 'innovation_theme_settings',
      '#weight' => -2
	);
	$form['enar_settings']['preloader'] = array(
      '#type' => 'select',
      '#title' => t('Enable Preloader'),
      '#options' => array(
		  ''=>t('Disable'), 
		  'preloader1'=>t('Preloader Style 01'), 
		  'preloader2'=>t('Preloader Style 02'),
		  'preloader3'=>t('Preloader Style 03')
	  ),
      '#default_value' => theme_get_setting('preloader'),
	);
	$form['enar_settings']['gototop'] = array(
      '#type' => 'select',
      '#title' => t('Show Scroll to top button'),
      '#options' => array(
		  1=>t('Yes'), 
		  0=>t('No')
	  ),
      '#default_value' => theme_get_setting('gototop'),
	);
}

