<?php

/**
* @file
* Contains \Drupal\carousel_formatter\Plugin\Field\FieldFormatter\CarouselFormatter.
*/

namespace Drupal\carousel_formatter\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceFormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Url;
use Drupal\image\Plugin\Field\FieldFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'carousel_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "carousel_formatter",
 *   label = @Translation("Carousel Bootstrap"),
 *   field_types = {
 *     "image"
 *   }
 * )
 */
class CarouselFormatter extends EntityReferenceFormatterBase implements ContainerFactoryPluginInterface {

  protected $currentUser;
  protected $imageStyleStorage;

  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, AccountInterface $current_user, EntityStorageInterface $image_style_storage) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->currentUser = $current_user;
    $this->imageStyleStorage = $image_style_storage;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('current_user'),
      $container->get('entity.manager')->getStorage('image_style')
    );
  }

   /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $image_styles = image_style_options(FALSE);
    $description_link = Link::fromTextAndUrl(
      $this->t('Configure Image Styles'),
      Url::fromRoute('entity.image_style.collection')
    );
    $element['image_style'] = [
      '#title' => t('Image style'),
      '#type' => 'select',
      '#default_value' => $this->getSetting('image_style'),
      '#empty_option' => t('None (original image)'),
      '#options' => $image_styles,
      '#description' => $description_link->toRenderable() + [
          '#access' => $this->currentUser->hasPermission('administer image styles')
        ],
    ];
    $link_types = array(
      'content' => t('Content'),
      'file' => t('File'),
	  'popup' => t('Popup'),
    );
    $element['image_link'] = array(
      '#title' => t('Link image to'),
      '#type' => 'select',
      '#default_value' => $this->getSetting('image_link'),
      '#empty_option' => t('Nothing'),
      '#options' => $link_types,
    );
    $element['control'] = array(
      '#title' => t('Show Controls'),
      '#type' => 'select',
      '#options' => array(
        1 => t('Yes'),
        0 => t('No'),
      ),
      '#default_value' => $this->getSetting('control'),
	  '#description' => t('Display Next/Previous control'),
    );
    $element['pager'] = array(
      '#title' => t('Control Pager'),
      '#type' => 'select',
      '#options' => array(
	    '' => t('No'),
        'control' => t('Control'),
        'thumbnail' => t('Thumbnail'),
      ),
	  '#default_value' => $this->getSetting('pager'),
	  '#description' => t('Show control pager'),	
    );

    $element['interval'] = array(
      '#title' => t('Interval'),
      '#description' => t('The amount of time to delay between automatically cycling an item. If false, carousel will not automatically cycle.'),
      '#type' => 'textfield',
      '#default_value' => $this->getSetting('interval'),
    );
    return $element + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.
	$settings = $this->getSettings();
    // Check image styles exist or display 'Original Image'.
    $summary[] = t('Carousel image style: @carousel_image_style. Display carousel control: @control_style. Display carousel pager: @pager_style', [
      '@carousel_image_style' => $this->getSetting('image_style') != "" ? $this->getSetting('image_style'): 'Original image',
      '@control_style' => $this->getSetting('control') == 1 ? 'Yes' : 'No',
	   '@pager_style' => $this->getSetting('pager') == "" ? 'No' : $this->getSetting('pager'),
    ]);
    return $summary;
  }

   /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
	$settings = array(
		'image_style' => '',
		'image_link' => '',
		'control' => 1,
		'pager' => 'control',
		'interval' => 5000,
    );
    return  $settings + parent::defaultSettings();
  }
  
  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
	$elements = array();
    $files = $this->getEntitiesToView($items, $langcode);
    // Early opt-out if the field is empty.
    if (empty($files)) {
      return $elements;
    }

    $url = NULL;
    $image_link_setting = $this->getSetting('image_link');
    // Check if the formatter involves a link.
    if ($image_link_setting == 'content') {
      $entity = $items->getEntity();
      if (!$entity->isNew()) {
        $url = $entity->urlInfo();
      }
    }
    elseif ($image_link_setting == 'file' || $image_link_setting == 'popup') {
      $link_file = TRUE;
    }

    $image_style_setting = $this->getSetting('image_style');

    // Collect cache tags to be added for each item in the field.
    $cache_tags = array();
    if (!empty($image_style_setting)) {
      $image_style = $this->imageStyleStorage->load($image_style_setting);
      $cache_tags = $image_style->getCacheTags();
    }
	$thumbs = array();
    foreach ($files as $delta => $file) {
	  $image_uri = $file->getFileUri();
	  $url_image = file_create_url($image_uri);
	  $thumbs[$delta] = $url_image;
      if (isset($link_file)) {
        $url = Url::fromUri(file_create_url($image_uri));
      }
      $cache_tags = Cache::mergeTags($cache_tags, $file->getCacheTags());


      // Extract field item attributes for the theme function, and unset them
      // from the $item so that the field template does not re-render them.
      $item = $file->_referringItem;
      $item_attributes = $item->_attributes;
      unset($item->_attributes);
		
      $elements[$delta] = array(
        '#theme' => 'image_formatter',
        '#item' => $item,
        '#item_attributes' => $item_attributes,
        '#image_style' => $image_style_setting,
        '#url' => $url,
        '#cache' => array(
          'tags' => $cache_tags,
        ),
      );
    }
    $settings = array();
	$settings['id'] = Html::getUniqueId('inv-bootstrap-carousel');
    $settings['control'] = $this->getSetting('control');
    $settings['pager'] = $this->getSetting('pager');
    $settings['interval'] = $this->getSetting('interval');
	
	if ($this->getSetting('image_link') == 'popup') {
		$settings['popup'] = true;
	}

    return array(
      '#theme' => 'carousel_field',
      '#items' => $elements,
      '#settings' => $settings,
	  '#thumbs' => $thumbs,
	  '#attached' => array('library' => array('carousel_formatter/custom-carousel'))
    );
  }
  
    /**
   * {@inheritdoc}
   */
  public function view(FieldItemListInterface $items, $langcode = NULL) {
    $elements = parent::view($items, $langcode);
    $gallery_type = 'all_items';
    $elements['#attributes']['class'][] = 'mfp-field';
    $elements['#attributes']['class'][] = 'mfp-' . Html::cleanCssIdentifier($gallery_type);
    return $elements;
  }
}