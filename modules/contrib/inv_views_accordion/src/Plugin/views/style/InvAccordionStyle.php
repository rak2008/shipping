<?php

/**
 * @file
 * Contains \Drupal\inv_views_accordion\Plugin\views\style\InvAccordionStyle.
 */

namespace Drupal\inv_views_accordion\Plugin\views\style;

use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Vocabulary;

/**
 * Style plugin to render each item in accordion bootstrap
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "inv_accordion_view",
 *   title = @Translation("Innovation Accordion View"),
 *   help = @Translation("Displays rows as accordion include filter"),
 *   theme = "views_view_invaccordion",
 *   display_types = {"normal"}
 * )
 */
class InvAccordionStyle extends StylePluginBase {

  /**
   * Does the style plugin for itself support to add fields to it's output.
   *
   * This option only makes sense on style plugins without row plugins, like
   * for example table.
   *
   * @var bool
   */
  protected $usesFields = TRUE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['title_field'] = array('default' => array());
	$options['accordion_filter'] = array('default' => 0);
    $options['accordion_filter_vocabulary'] = array('default'=>'select');
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $form['title_field'] = array(
        '#type' => 'select',
        '#title' => $this->t('Title field'),
        '#options' => $this->displayHandler->getFieldLabels(TRUE),
        '#required' => TRUE,
        '#default_value' => $this->options['title_field'],
        '#description' => $this->t('Select the field that will be used as the title.'),
    );
    $form['accordion_filter'] = array(
      '#type' => 'select',
      '#title' => t('Use Filter'),
      '#options' => array(0=>t('No'),1=>t('Yes')),
      '#description' => t('Filter items by taxonomy term'),
      '#default_value' => $this->options['accordion_filter'],
      '#attributes' => array('class' => array('accordion-filter-option')),
    );
    $categories = array();
    $categories['select'] = t('Select');
    foreach (Vocabulary::loadMultiple() as $vocabulary) {
        $categories[$vocabulary->id()] = $vocabulary->get('name');
    }
    $form['accordion_filter_vocabulary'] = array(
      '#type' => 'select',
      '#title' => t('Filter Vocabulary'),
      '#options' => $categories,
      '#description' => t('Which taxonomy vocabulary do you want to use for the filter'),
      '#default_value' => $this->options['accordion_filter_vocabulary'],
	  '#states' => array(
          'visible' => array(
              '.accordion-filter-option' => array('value' => 1),
          ),
		)
    );
  }
}
