<?php

function innovation_fonts_settings_form_alter(&$form) {
  $form['fonts_settings'] = array(
      '#type' => 'details',
      '#title' => 'Font Settings',
      '#group' => 'innovation_theme_settings',
      '#weight' => -1
  );
  $form['fonts_settings']['innovation_fonts'] = array(
      '#markup' => '<div id="fonts"></div>',
  );
  $theme_key = \Drupal::theme()->getActiveTheme()->getName();
  if (function_exists($theme_key.'_fonts')) {
    $fonts = call_user_func($theme_key.'_fonts');
  }else{
    $fonts = array(
      'body' => array(
        '#title' => t('Body Font'),
        '#description' => t('Typography option with each property can be called individually.'),
      ),
      'h1' => array(
        '#title' => t('H1'),
      ),
      'h2' => array(
        '#title' => t('H2'),
      ),
      'h3' => array(
        '#title' => t('H3'),
      ),
      'h4' => array(
        '#title' => t('H4'),
      ),
      'h5' => array(
        '#title' => t('H5'),
      ),
      'h6' => array(
        '#title' => t('H6'),
      ),
    );
  }
  $general_fonts = array(1,2,3,4,5);
  $form['fonts_settings']['global'] = array(
    '#type' => 'fieldset',
    '#title' => t('Global fonts'),
    '#description' => t('Global fonts use in CSS'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  $form['fonts_settings']['general'] = array(
    '#type' => 'fieldset',
    '#title' => t('General fonts'),
    '#description' => t('Define font for basic tag (body, heading...)'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );

  $form['fonts_settings']['custom'] = array(
    '#type' => 'fieldset',
    '#title' => t('Custom fonts'),
    '#description' => t('Define font for special elements'),
    '#collapsible' => TRUE,
    '#collapsed' => TRUE,
  );
  foreach($general_fonts as $font){
    $form['fonts_settings']['global']['global_font_'.$font] = array(
      '#type' => 'textfield',
      '#default_value' => theme_get_setting('global_font_'.$font),
      '#attributes' => array('class'=>array('google-font','global-font')),
      //'#title' => t('Custom font #'.$font),
      '#maxlength' => 256,
    );
  }
  foreach($fonts as $key=>$font){
    $font['#type'] = 'textfield';
    $font['#default_value'] = theme_get_setting($key);
    $font['#attributes'] = array('class'=>array('google-font'));
    $form['fonts_settings']['general'][$key] = $font;

  }
  $custom_fonts = array(1,2,3,4,5,6,7,8,9,10);
  foreach($custom_fonts as $font){
    $form['fonts_settings']['custom']['custom_font_'.$font] = array(
      '#type' => 'textfield',
      '#default_value' => theme_get_setting('custom_font_'.$font),
      '#attributes' => array('class'=>array('google-font','custom-font')),
      '#title' => t('Custom font #'.$font),
      '#maxlength' => 256,
    );
  }
  $fonts = json_decode(file_get_contents(__DIR__.'/font-list.json'));
  foreach($fonts->items as $k=>$font){
    $fonts->items[$k]->label = $font->family;
    $fonts->items[$k]->value = $font->family;
    if(!isset($fonts->items[$k]->{'data-google'})){
      $fonts->items[$k]->{'data-google'} = true;
    }
  }
  $form['#attached']['library'][] = 'core/drupal.autocomplete';
  $form['#attached']['drupalSettings'] = array_merge($form['#attached']['drupalSettings'],array('google_fonts' => $fonts));
}
