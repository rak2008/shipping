<?php

/**
 * @file
 * Contains Drupal\formblock\Plugin\Block\ContactFormBlock.
 */

namespace Drupal\formblock\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatter;
use Drupal\Core\Entity\EntityFormBuilderInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Flood\FloodInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Access\AccessResult;

/**
 * Provides a block for contact form.
 *
 * @Block(
 *   id = "formblock_contact",
 *   admin_label = @Translation("Site-wide contact form"),
 *   provider = "contact"
 * )
 *
 * Note that we set module to contact so that blocks will be disabled correctly
 * when the module is disabled.
 */
class ContactFormBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface.
   */
  protected $entityManager;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface.
   */
  protected $currentUser;

  /**
   * The entity form builder.
   *
   * @var \Drupal\Core\Entity\EntityFormBuilderInterface.
   */
  protected $entityFormBuilder;

  /**
   * The entity form builder.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface.
   */
  protected $configFactory;

  /**
   * The flood service.
   *
   * @var \Drupal\Core\Flood\FloodInterface.
   */
  protected $flood;

  /**
   * The contact_form that corresponds to this block.
   *
   * @var \Drupal\contact\Entity\ContactForm
   */
  protected $contactForm;

  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatter.
   */
  protected $dateFormatter;

  /**
   * Constructs a new ContactFormBlock plugin.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user.
   * @param \Drupal\Core\Entity\EntityFormBuilderInterface $entity_form_builder
   *   The entity form builder interface.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Flood\FloodInterface $flood
   *   The flood service.
   * @param \Drupal\Core\DateTime\DateFormatter $date_formatter
   *   The date formatter service.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityManagerInterface $entity_manager, AccountInterface $current_user, EntityFormBuilderInterface $entity_form_builder, ConfigFactoryInterface $config_factory, FloodInterface $flood, DateFormatter $date_formatter) {
    $this->entityManager = $entity_manager;
    $this->currentUser = $current_user;
    $this->entityFormBuilder = $entity_form_builder;
    $this->configFactory = $config_factory;
    $this->flood = $flood;
    $this->dateFormatter = $date_formatter;

    // We have to do this after our injections since the parent constructor
    // calls defaultConfiguration() which depends on the configFactory service.
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->contactForm = $this->entityManager->getStorage('contact_form')->load($this->configuration['contact_form']);
  }

  /**
   * Creates an instance of the plugin.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The container to pull out services used in the plugin.
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   *
   * @return static
   *   Returns an instance of this plugin.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity.manager'),
      $container->get('current_user'),
      $container->get('entity.form_builder'),
      $container->get('config.factory'),
      $container->get('flood'),
      $container->get('date.formatter')
    );
  }

  /**
   * Overrides \Drupal\block\BlockBase::settings().
   */
  public function defaultConfiguration() {
    return array(
      'contact_form' => $this->configFactory->get('contact.settings')->get('default_form'),
    );
  }

  /**
   * Overrides \Drupal\block\BlockBase::blockForm().
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $categories = $this->entityManager->getStorage('contact_form')->loadMultiple();

    $options = array();
    foreach ($categories as $category) {
      $options[$category->id()] = $category->label();
    }

    $form['formblock_contact_form'] = array(
      '#type' => 'select',
      '#title' => $this->t('Category'),
      '#default_value' => $this->configuration['contact_form'],
      '#description' => $this->t('Select the category to show.'),
      '#options' => $options,
      '#required' => TRUE,
    );

    return $form;
  }

  /**
   * Overrides \Drupal\block\BlockBase::blockSubmit().
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['contact_form'] = $form_state->getValue('formblock_contact_form');
  }

  /**
   * Implements \Drupal\block\BlockBase::build().
   */
  public function build() {
    $build = array();

    // Check if flood control has been activated for sending emails.
    if (!$this->currentUser->hasPermission('administer contact forms') && $message = $this->floodControl()) {
      $build['message'] = array(
        '#markup' => $message,
      );
      return $build;
    }

    $message = $this->entityManager
      ->getStorage('contact_message')
      ->create(array(
        'contact_form' => $this->contactForm->id(),
      ));

    $build['form'] = $this->entityFormBuilder->getForm($message);

    return $build;
  }

  /**
   * Implements \Drupal\block\BlockBase::blockAccess().
   */
  public function blockAccess(AccountInterface $account) {
    if ($this->contactForm->access('view', $account) && $account->hasPermission('access site-wide contact form')) {
      return AccessResult::allowed();
    }
    else {
      return AccessResult::forbidden();
    }
  }

  /**
   * Returns the current status of flood control.
   *
   * @return bool
   *   Checking if the user can submit more contact forms.
   */
  protected function floodControl() {
    $limit = $this->configFactory->get('contact.settings')->get('flood.limit');
    $interval = $this->configFactory->get('contact.settings')->get('flood.interval');

    if (!$this->flood->isAllowed('contact', $limit, $interval)) {
      return $this->t('You cannot send more than %limit messages in @interval. Try again later.', array(
        '%limit' => $limit,
        '@interval' => $this->dateFormatter->formatInterval($interval),
      ));
    }

    return FALSE;
  }

}
