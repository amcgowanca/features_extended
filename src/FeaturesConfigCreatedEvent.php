<?php

namespace Drupal\features_extended;

use Symfony\Component\EventDispatcher\Event;

/**
 * Event context class for configuration creation events in Features.
 */
class FeaturesConfigCreatedEvent extends Event {

  /**
   * An array of new configuration items.
   *
   * @var array|\Drupal\features\ConfigurationItem[]
   */
  protected $newConfig = [];

  /**
   * An array of updated configuration items.
   *
   * @var array|\Drupal\features\ConfigurationItem[]
   */
  protected $updatedConfig = [];

  /**
   * FeaturesConfigCreatedEvent constructor.
   *
   * @param \Drupal\features\ConfigurationItem[] $new_config
   *   An array of configuration items marked as "new".
   * @param \Drupal\features\ConfigurationItem[] $updated_config
   *   An array of configuration items marked as "updated".
   */
  public function __construct(array $new_config, array $updated_config) {
    $this->newConfig = $new_config;
    $this->updatedConfig = $updated_config;
  }

  /**
   * Returns an array of newly created configuration items.
   *
   * @return \Drupal\features\ConfigurationItem[]
   *   An array of items, marked as "new", in the config installer.
   */
  public function getNewConfig() {
    return $this->newConfig;
  }

  /**
   * Returns an array of updated configuration items.
   *
   * @return \Drupal\features\ConfigurationItem[]
   *   An array of items, marked as "updated", in the config installer.
   */
  public function getUpdatedConfig() {
    return $this->updatedConfig;
  }

}
