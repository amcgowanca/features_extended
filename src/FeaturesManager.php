<?php

namespace Drupal\features_extended;

use Drupal\config_update\ConfigRevertInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Config\ConfigManagerInterface;
use Drupal\Core\Config\StorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\features\FeaturesManager as FeaturesManagerBase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Overrides the Features Manager service class to enhance its operations.
 */
class FeaturesManager extends FeaturesManagerBase implements FeaturesConfigCreatedInterface {

  /**
   * The event dispatcher.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $dispatcher;

  /**
   * {@inheritdoc}
   */
  public function __construct($root, EntityTypeManagerInterface $entity_type_manager, ConfigFactoryInterface $config_factory, StorageInterface $config_storage, ConfigManagerInterface $config_manager, ModuleHandlerInterface $module_handler, ConfigRevertInterface $config_reverter, EventDispatcherInterface $dispatcher) {
    parent::__construct($root, $entity_type_manager, $config_factory, $config_storage, $config_manager, $module_handler, $config_reverter);
    $this->dispatcher = $dispatcher;
  }

  /**
   * {@inheritdoc}
   */
  public function createConfiguration(array $config_to_create) {
    $result = parent::createConfiguration($config_to_create);
    // Dispatch the Features configuration created event, allowing other modules
    // to act on when a feature's configuration has been changed through this
    // interface itself.
    $event = new FeaturesConfigCreatedEvent($result['new'], $result['updated']);
    $this->dispatcher->dispatch(FeaturesConfigCreatedInterface::CONFIG_CREATED, $event);
    return $result;
  }

}
