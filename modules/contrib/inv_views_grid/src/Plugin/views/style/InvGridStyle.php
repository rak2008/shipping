<?php

/**
 * @file
 * Contains \Drupal\inv_views_bxslider\Plugin\views\style\BxSliderStyle.
 */

namespace Drupal\inv_views_grid\Plugin\views\style;

use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Style plugin to render each item in responsive grid
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "inv_grid_view",
 *   title = @Translation("Innovation Grid View"),
 *   help = @Translation("Displays rows as grid responsive"),
 *   theme = "views_view_invgrid",
 *   display_types = {"normal"}
 * )
 */
class InvGridStyle extends StylePluginBase {

  /**
   * Does the style plugin allows to use style plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;

  /**
   * Does the style plugin support custom css class for the rows.
   *
   * @var bool
   */
  protected $usesRowClass = FALSE;

  /**
   * Does the style plugin support grouping of rows.
   *
   * @var bool
   */
  protected $usesGrouping = FALSE;

  /**
   * Does the style plugin for itself support to add fields to it's output.
   *
   * This option only makes sense on style plugins without row plugins, like
   * for example table.
   *
   * @var bool
   */
  protected $usesFields = FALSE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['grid_style'] = array('default' => 'classic');
    $options['grid_cols_lg'] = array('default' => 4);
    $options['grid_cols_md'] = array('default' => 3);
    $options['grid_cols_sm'] = array('default' => 2);
    $options['grid_cols_xs'] = array('default' => 1);
    $options['grid_margin'] = array('default' => 30);
    $options['grid_filter'] = array('default' => 0);
    $options['grid_ratio'] = array('default' => 1);
    $options['grid_filter_vocabulary'] = array('default'=>'select');
    $options['masonry_background'] = array('default' => '');
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    $form['grid_style'] = array(
        '#prefix' => '<h4>Grid Settings</h4>',
        '#type' => 'select',
        '#title' => t('Mode'),
        '#description' => t('Choose grid style:'),
        '#options' => array(
            'classic' => t('Classic Grid'),
            'masonry' => t('Masonry Simple'),
            'masonry_resize' => t('Masonry Resize'),
        ),
        '#default_value' => $this->options['grid_style'],
        '#attributes' => array('class' => array('grid-style')),
    );
      $field_options = array();
      $fields = \Drupal::entityManager()->getFieldMapByFieldType('image');

      foreach($fields as $field){
          foreach($field as $key => $value){
              $field_options[$key] = $key;
          }
     }
      $form['masonry_background'] = array(
          '#type' => 'select',
          '#title' => t('Image'),
          '#options' => $field_options,
          '#default_value' => $this->options['masonry_background'],
          '#states' => array(
              'visible' => array(
                  '.grid-style' => array('value' => 'masonry_resize'),
              )
          )
      );
      $form['grid_ratio'] = array(
          '#type' => 'textfield',
          '#title' => t('Ratio'),
          '#description' => t('The ratio image'),
          '#default_value' => $this->options['grid_ratio'],
          '#states' => array(
              'visible' => array(
                  '.grid-style' => array('value' => 'masonry_resize'),
              )
          )
      );
    $form['grid_cols_lg'] = array(
        '#type' => 'select',
        '#title' => t('Large Desktop Items'),
        '#description' => t('Number of items on large desktop'),
        '#options' =>  array(1=>1, 2=>2, 3 => 3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8,9=>9, 10=>10, 11=>11, 12=>12),
        '#default_value' => $this->options['grid_cols_lg'],
    );
    $form['grid_cols_md'] = array(
        '#type' => 'select',
        '#title' => t('Desktop Items'),
        '#description' => t('Number of items on desktop'),
        '#options' =>  array(1=>1, 2=>2, 3 => 3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8,9=>9, 10=>10, 11=>11, 12=>12),
        '#default_value' => $this->options['grid_cols_md'],
    );
    $form['grid_cols_sm'] = array(
        '#type' => 'select',
        '#title' => t('Tablet Items'),
        '#description' => t('Number of items on tablet'),
        '#options' =>  array(1=>1, 2=>2, 3 => 3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8,9=>9, 10=>10, 11=>11, 12=>12),
        '#default_value' => $this->options['grid_cols_sm'],
    );
    $form['grid_cols_xs'] = array(
        '#type' => 'select',
        '#title' => t('Phone Items'),
        '#description' => t('Number of items on phone'),
        '#options' => array(1=>1, 2=>2, 3 => 3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8,9=>9, 10=>10, 11=>11, 12=>12),
        '#default_value' => $this->options['grid_cols_xs'],
    );
    $form['grid_margin'] = array(
      '#type' => 'textfield',
      '#title' => t('Margin'),
      '#description' => t('The spacing beetween items'),
      '#default_value' => $this->options['grid_margin'],
      '#field_suffix' => 'px',
    );
    $form['grid_filter'] = array(
      '#type' => 'select',
      '#title' => t('Use Filter'),
      '#options' => array(0=>t('No'),1=>t('Yes')),
      '#description' => t('Filter items by taxonomy term'),
      '#default_value' => $this->options['grid_filter'],
      '#attributes' => array('class' => array('grid-filter-option')),
    );

    $categories = array();
    $categories['select'] = t('Select');
    foreach (Vocabulary::loadMultiple() as $vocabulary) {
        $categories[$vocabulary->id()] = $vocabulary->get('name');
    }
    $form['grid_filter_vocabulary'] = array(
      '#type' => 'select',
      '#title' => t('Filter Vocabulary'),
      '#options' => $categories,
      '#description' => t('Which taxonomy vocabulary do you want to use for the filter'),
      '#default_value' => $this->options['grid_filter_vocabulary'],
      '#states' => array(
          'visible' => array(
              '.grid-filter-option' => array('value' => 1),
          ),
      )
    );
  }
}
