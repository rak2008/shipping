<?php

namespace Drupal\shortcode\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * @Filter(
 *   id = "filter_shortcode",
 *   title = @Translation("Shortcode Filter"),
 *   description = @Translation("Provides shortcodes filter to this text format."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class FilterShortcode extends FilterBase
{
    public function process($text, $langcode) {
        $text_filter = _shortcode_process($text, $this->settings);
        return new FilterProcessResult($text_filter);
    }

    public function settingsForm(array $form, FormStateInterface $form_state) {
        $settings = array();
        $shortcodes = shortcode_list_all();
        foreach ($shortcodes as $key => $shortcode) {
            $settings[$key] = array(
                '#type' => 'checkbox',
                '#title' => t('Enable %name shortcode', array('%name' => $shortcode['title'])),
                '#default_value' => isset($this->settings[$key])? $this->settings[$key]: NULL,
                '#description' => isset($shortcode['description']) ? $shortcode['description'] : t('Enable or disable this shortcode in this input format'),
            );
        }
        return $settings;

    }
}