<?php

/**
 * @file
 * Contains \Drupal\inv_quicksettings\Plugin\Block\InnovationQuickSettings.
 */

namespace Drupal\inv_quicksettings\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Provides a 'Flickr' block.
 *
 * @Block(
 *   id = "inv_quicksettings",
 *   admin_label = @Translation("Quick Settings"),
 *   category = @Translation("Custom Block")
 * )
 */
class InnovationQuickSettings extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
        $presets = inv_quicksettings_presets();
        return array(
            '#theme' => 'quicksettings',
            '#presets' => $presets,
			'#attached' => array(
				'library' =>  array(
				  'inv_quicksettings/quicksettings'
				),
			)
        );
    }
}