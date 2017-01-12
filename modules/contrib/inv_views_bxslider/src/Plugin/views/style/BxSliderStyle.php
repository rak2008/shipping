<?php

/**
 * @file
 * Contains \Drupal\inv_views_bxslider\Plugin\views\style\BxSliderStyle.
 */

namespace Drupal\inv_views_bxslider\Plugin\views\style;

use Drupal\views\Plugin\views\style\StylePluginBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Style plugin to render each item in slide format using bxslider
 *
 * @ingroup views_style_plugins
 *
 * @ViewsStyle(
 *   id = "bxslider_view",
 *   title = @Translation("BxSlider View"),
 *   help = @Translation("Displays rows as Bxslider"),
 *   theme = "views_view_bxslider",
 *   display_types = {"normal"}
 * )
 */
class BxSliderStyle extends StylePluginBase {

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
  protected $usesRowClass = TRUE;

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
  protected $usesFields = TRUE;

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['mode'] = array('default' => 'horizontal');
    $options['speed'] = array('default' => 500);
    $options['touchEnabled'] = array('default' => 1);
    $options['auto'] = array('default' => 0);
    $options['pause'] = array('default' => 4000);
    $options['infiniteloop'] = array('default' => 1);
    $options['slidemargin'] = array('default' => 0);
    $options['startslide'] = array('default' => 0);
    $options['randomstart'] = array('default' => 0);

    $options['pager'] = array('default' => 1);
    $options['controls'] = array('default' => 1);
    $options['nexttext'] = array('default' => '');
    $options['prevtext'] = array('default' => '');
    $options['autoControls'] = array('default' => 0);

    // Carousel options
    $options['moveslides'] = array('default' => 0);
    $options['lg_items'] = array('default' => 4);
    $options['md_items'] = array('default' => 3);
    $options['sm_items'] = array('default' => 2);
    $options['xs_items'] = array('default' => 1);

    $options['ticker'] = array('default' => 0);
    $options['tickerHover'] = array('default' => 0);
    
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    $form['mode'] = array(
        '#prefix' => '<h4>bxSlider Settings</h4>',
        '#type' => 'select',
        '#title' => t('Mode'),
        '#description' => t('Type of transition between slides'),
        '#options' => array(
            'horizontal' => t('Horizontal'),
            'vertical' => t('Vertical'),
            'fade' => t('Fade'),
        ),
        '#default_value' => $this->options['mode'],
    );

    $form['ticker'] = array(
        '#type' => 'select',
        '#title' => t('Ticker Enabled'),
        '#description' => t('If yes, use slider in ticker mode (similar to a news ticker)'),
        '#options' => array(
            true => 'Yes',
            false => 'No',
        ),
        '#default_value' => $this->options['ticker'],
    );

    $form['tickerHover'] = array(
        '#type' => 'select',
        '#title' => t('Ticker Hover'),
        '#description' => t('Ticker will pause when mouse hovers over slider. Note: this functionality does NOT work if using CSS transitions!'),
        '#options' => array(
            true => 'Yes',
            false => 'No',
        ),
        '#default_value' => $this->options['tickerHover'],
    );


    $form['speed'] = array(
        '#type' => 'textfield',
        '#title' => t('Speed'),
        '#description' => t('Slide transition duration (in ms)'),
        '#default_value' => $this->options['speed'],
    );
    
    $form['touchEnabled'] = array(
        '#type' => 'select',
        '#title' => t('Touch Enabled'),
        '#description' => t('If yes, slider will allow touch swipe transitions'),
        '#options' => array(
            true => 'Yes',
            false => 'No',
        ),
        '#default_value' => $this->options['touchEnabled'],
    );
    
    $form['auto'] = array(
        '#type' => 'select',
        '#title' => t('Auto'),
        '#description' => t('Slides will automatically transition.'),
        '#options' => array(
            true => 'Yes',
            false => 'No',
        ),
        '#default_value' => $this->options['auto'],
    );

    $form['pause'] = array(
        '#type' => 'textfield',
        '#title' => t('Pause'),
        '#description' => t('The amount of time (in ms) between each auto transition.'),
        '#default_value' => $this->options['pause'],
    );

    $form['infiniteloop'] = array(
        '#type' => 'select',
        '#title' => t('Infinite'),
        '#description' => t('If true, clicking "Next" while on the last slide will transition to the first slide and vice-versa'),
        '#options' => array(
            true => t('Yes'),
            false => t('No'),
        ),
        '#default_value' => $this->options['infiniteloop'],
    );

    $form['slidemargin'] = array(
        '#type' => 'textfield',
        '#title' => t('Slide Margin'),
        '#description' => t('Margin between each slide'),
        '#default_value' => $this->options['slidemargin'],
    );

    $form['startslide'] = array(
        '#type' => 'textfield',
        '#title' => t('Start Slide'),
        '#description' => t('Starting slide index (zero-based)'),
        '#default_value' => $this->options['startslide'],
    );

    $form['randomstart'] = array(
        '#type' => 'select',
        '#title' => t('Random Start'),
        '#options' => array(
            true => t('Yes'),
            false => t('No'),
        ),
        '#description' => t('Start slider on a random slide'),
        '#default_value' => $this->options['randomstart'],
    );

    $form['pager'] = array(
        '#type' => 'select',
        '#title' => t('Show Pager'),
        '#description' => t('If yes, a pager will be added.'),
        '#options' => array(
            true => 'Yes',
            false => 'No',
        ),
        '#default_value' => $this->options['pager'],
    );

    $form['controls'] = array(
        '#type' => 'select',
        '#title' => t('Show Controls'),
        '#description' => t('If yes, next/prev controls will be added.'),
        '#options' => array(
            true => 'Yes',
            false => 'No',
        ),
        '#default_value' => $this->options['controls'],
    );
    
    $form['nexttext'] = array(
        '#type' => 'textfield',
        '#title' => t('Custom nextText'),
        '#description' => t('Custom text to be used for the "Next" control'),
        '#default_value' => $this->options['nexttext'],
    );
    
    $form['prevtext'] = array(
        '#type' => 'textfield',
        '#title' => t('Custom prevText'),
        '#description' => t('Custom text to be used for the "Prev" control'),
        '#default_value' => $this->options['prevtext'],
    );

    $form['autoControls'] = array(
        '#type' => 'select',
        '#title' => t('Show Auto Controls'),
        '#description' => t('If Yes, "Start" / "Stop" controls will be added. Note: this functionality work if auto is true!'),
       '#options' => array(
            true => 'Yes',
            false => 'No',
        ),
        '#default_value' => $this->options['autoControls'],
    );

    $form['moveslides'] = array(
        '#type' => 'textfield',
        '#title' => t('Move Slides'),
        '#description' => t('The number of slides to move on transition. This value must be >= minSlides, and <= maxSlides. If zero (default), the number of fully-visible slides will be used.'),
        '#default_value' => $this->options['moveslides'],
    );
    $form['lg_items'] = array(
        '#type' => 'select',
        '#title' => t('Large Desktop Items'),
        '#description' => t('Number of items on large desktop'),
        '#options' =>  array(1=>1, 2=>2, 3 => 3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8,9=>9, 10=>10, 11=>11, 12=>12),
        '#default_value' => $this->options['lg_items'],
    );
    $form['md_items'] = array(
        '#type' => 'select',
        '#title' => t('Desktop Items'),
        '#description' => t('Number of items on desktop'),
        '#options' =>  array(1=>1, 2=>2, 3 => 3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8,9=>9, 10=>10, 11=>11, 12=>12),
        '#default_value' => $this->options['md_items'],
    );
    $form['sm_items'] = array(
        '#type' => 'select',
        '#title' => t('Tablet Items'),
        '#description' => t('Number of items on tablet'),
        '#options' =>  array(1=>1, 2=>2, 3 => 3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8,9=>9, 10=>10, 11=>11, 12=>12),
        '#default_value' => $this->options['sm_items'],
    );
    $form['xs_items'] = array(
        '#type' => 'select',
        '#title' => t('Phone Items'),
        '#description' => t('Number of items on phone'),
        '#options' => array(1=>1, 2=>2, 3 => 3, 4=>4, 5=>5, 6=>6, 7=>7, 8=>8,9=>9, 10=>10, 11=>11, 12=>12),
        '#default_value' => $this->options['xs_items'],
    );
  }
}
