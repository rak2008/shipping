<?php

function innovation_basic_settings_form_alter(&$form) {
  $pagewidth = theme_get_setting('innovation_pagewidth');
  if(empty($pagewidth)) $pagewidth = 1170;
  $form['basic_settings'] = array(
      '#type' => 'details',
      '#title' => t('Basic Settings'),
      '#group' => 'innovation_theme_settings',
      '#weight' => -2
  );
  $form['basic_settings']['innovation_pagewidth'] = array(
      '#type' => 'textfield',
      '#title' => t('Page Width'),
      '#default_value' => $pagewidth
  );
  $form['basic_settings']['innovation_smoothscroll'] = array(
      '#type' => 'select',
      '#title' => t('Enable SmoothScroll'),
      '#options' => array(1 => 'Yes', 0 => 'No'),
      '#default_value' => theme_get_setting('innovation_smoothscroll')
  );
  $form['basic_settings']['innovation_layout'] = array(
      '#type' => 'select',
      '#title' => t('Layout'),
      '#options' => array('wide' => 'Wide', 'boxed' => 'Boxed'),
      '#default_value' => theme_get_setting('innovation_layout')
  );
   $form['basic_settings']['innovation_direction'] = array(
      '#type' => 'select',
      '#title' => t('Direction'),
      '#options' => array('default'=>t('Default (Current language direction)'), 'ltr' => 'LTR', 'rtl' => 'RTL'),
      '#default_value' => theme_get_setting('innovation_direction')
  );
  $form['basic_settings']['innovation_wrapper_class'] = array(
      '#type' => 'textfield',
      '#title' => t('Custom HTML class'),
      '#description'=>t('Provides this text as an additional body class (in $classes in html.html.twig) when this section is active.'),
      '#default_value' => theme_get_setting('innovation_wrapper_class')
  );
}
