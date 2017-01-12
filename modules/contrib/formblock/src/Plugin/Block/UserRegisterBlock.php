<?php

/**
 * @file
 * Contains Drupal\formblock\Plugin\Block\UserRegisterBlock.
 */

namespace Drupal\formblock\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Entity\EntityFormBuilderInterface;

/**
 * Provides a block for the user registration form.
 *
 * @Block(
 *   id = "formblock_user_register",
 *   admin_label = @Translation("User registration form"),
 *   provider = "user"
 * )
 *
 * Note that we set module to contact so that blocks will be disabled correctly
 * when the module is disabled.
 */
class UserRegisterBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface.
   */
  protected $entityManager;

  /**
   * The entity form builder.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface.
   */
  protected $entityFormBuilder;

  /**
   * Constructs a new UserRegisterBlock plugin.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager.
   * @param \Drupal\Core\Entity\EntityFormBuilderInterface $entity_form_builder
   *   The entity form builder.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityManagerInterface $entity_manager, EntityFormBuilderInterface $entity_form_builder) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityManager = $entity_manager;
    $this->entityFormBuilder = $entity_form_builder;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity.manager'),
      $container->get('entity.form_builder')
    );
  }

  /**
   * Implements \Drupal\block\BlockBase::build().
   */
  public function build() {
    $build = array();

    $account = $this->entityManager->getStorage('user')->create(array());
    $build['form'] = $this->entityFormBuilder->getForm($account, 'register');

    return $build;
  }

  /**
   * Implements \Drupal\block\BlockBase::blockAccess().
   */
  public function blockAccess(AccountInterface $account) {
    return ($account->isAnonymous()) && (\Drupal::config('user.settings')->get('register') != USER_REGISTER_ADMINISTRATORS_ONLY);
  }

}
