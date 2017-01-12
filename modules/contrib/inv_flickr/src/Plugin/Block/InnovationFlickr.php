<?php

/**
 * @file
 * Contains \Drupal\inv_flickr\Plugin\Block\InnovationFlickr.
 */

namespace Drupal\inv_flickr\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Provides a 'Flickr' block.
 *
 * @Block(
 *   id = "inv_flickr",
 *   admin_label = @Translation("Innovation Flickr"),
 *   category = @Translation("Custom Block")
 * )
 */
class InnovationFlickr extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);
        $config = $this->getConfiguration();

        $form['flickr_source'] = array(
            '#type' => 'select',
            '#title' => t('Source pulling images'),
            '#default_value' => isset($config['flickr_source']) ? $config['flickr_source']: 'user',
            '#description' => $this->t('Pulling from a Flickr user or Flickr group or Flickr user set or Tag'),
            '#options' => array(
                'user' => 'User',
                'group' => 'Group',
                'user_set' => 'User set',
                'all_tag' => 'Tag'
            )
        );
        $form['flickr_userId'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Flickr User ID:'),
            '#description' => $this->t('Input your Flickr User ID'),
            '#default_value' => isset($config['flickr_userId']) ? $config['flickr_userId']: '',
            '#states' => array(
                'visible' => array(
                    'select[name="settings[flickr_source]"]' => array('value' => t('user')),
                ),
            ),
        );
        $form['flickr_groupId'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Flickr Group ID:'),
            '#description' => $this->t('Input your Flickr Group ID'),
            '#default_value' => isset($config['flickr_groupId']) ? $config['flickr_groupId']: '',
            '#states' => array(
                'visible' => array(
                    'select[name="settings[flickr_source]"]' => array('value' => t('group')),
                ),
            ),
        );
        $form['flickr_setId'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Set ID:'),
            '#description' => $this->t('Input your Flickr Set ID'),
            '#default_value' => isset($config['flickr_setId']) ? $config['flickr_setId']: '',
            '#states' => array(
                'visible' => array(
                    'select[name="settings[flickr_source]"]' => array('value' => t('user_set')),
                ),
            ),
        );
        $form['flickr_tag'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Tags:'),
            '#description' => $this->t('Each tag needs to be seperated by a comma'),
            '#default_value' => isset($config['flickr_tag']) ? $config['flickr_tag']: '',
            '#states' => array(
                'visible' => array(
                    'select[name="settings[flickr_source]"]' => array('value' => t('all_tag')),
                ),
            ),
        );
        $form['flickr_num_photo'] = array(
            '#type' => 'select',
            '#title' => t('Number of images being pulled'),
            '#default_value' => isset($config['flickr_num_photo']) ? $config['flickr_num_photo']: 4,
            '#description' => $this->t('How many images to show in Flickr block'),
            '#options' => array(
                2 => '2',3 => '3',4 => '4',5 => '5',6 => '6',7 => '7',8 => '8',9 => '9',10 => '10'),
        );
        $form['flickr_display'] = array(
            '#type' => 'select',
            '#title' => $this->t('Ordering your images'),
            '#description' => $this->t('You can get random or latest images from Flickr'),
            '#options' => array(
                'latest' => 'Latest Images',
                'random' => 'Random Images',
            ),
            '#default_value' => isset($config['flickr_display']) ? $config['flickr_display'] : 'latest'
        );
        $form['flickr_image_size'] = array(
            '#type' => 'select',
            '#title' => $this->t('Size of your images'),
            '#description' => $this->t('Small square box (75 pixels by 75 pixels), Thumbnail size (longest side is 100 pixels), and Medium size(longest side is 240 pixels)'),
            '#options' => array(
                't' => 'Thumbnail',
                's' => 'Small',
                'm' => 'Medium'
            ),
            '#default_value' => isset($config['flickr_image_size']) ? $config['flickr_image_size'] : 't'
        );
        $form['flickr_layout'] = array(
            '#type' => 'select',
            '#title' => $this->t('Layout display images'),
            '#description' => $this->t('Layout can be horizontal or default div tag for render HTML output'),
            '#options' => array(
                'x' => 'Default',
                'h' => 'Horizontal',
            ),
            '#default_value' => isset($config['flickr_layout']) ? $config['flickr_layout'] : 'x'
        );
        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->setConfigurationValue('flickr_source', $form_state->getValues()['flickr_source']);
        $this->setConfigurationValue('flickr_userId', $form_state->getValues()['flickr_userId']);
        $this->setConfigurationValue('flickr_groupId', $form_state->getValues()['flickr_groupId']);
        $this->setConfigurationValue('flickr_setId', $form_state->getValues()['flickr_setId']);
        $this->setConfigurationValue('flickr_num_photo', $form_state->getValues()['flickr_num_photo']);
        $this->setConfigurationValue('flickr_display',  $form_state->getValues()['flickr_display']);
        $this->setConfigurationValue('flickr_image_size',  $form_state->getValues()['flickr_image_size']);
        $this->setConfigurationValue('flickr_layout',  $form_state->getValues()['flickr_layout']);
        $this->setConfigurationValue('flickr_tag',  $form_state->getValues()['flickr_tag']);
    }

    /**
     * {@inheritdoc}
     */
    public function build() {
        $config = $this->getConfiguration();
        $accId = "";
        switch ($config['flickr_source']) {
            case "user" :
                $accId = "user=".$config['flickr_userId'];
                break;
            case "group":
                $accId = "group=".$config['flickr_groupId'];
                break;
            case "user_set":
                $accId = "set=".$config['flickr_setId'];
                break;
            case "all_tag":
                $accId = "tag=".$config['flickr_tag'];
                break;
            default :
                $accId = "user=".$config['flickr_userId'];
        }
        return array(
            '#theme' => 'flickr',
            '#flickr_source' => $config['flickr_source'],
            '#flickr_id' => $accId,
            '#flickr_num_photo' => $config['flickr_num_photo'],
            '#flickr_image_size' => $config['flickr_image_size'],
            '#flickr_display' => $config['flickr_display'],
            '#flickr_layout' => $config['flickr_layout'],
        );
    }
}