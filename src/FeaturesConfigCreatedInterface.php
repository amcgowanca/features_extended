<?php

namespace Drupal\features_extended;

/**
 * Defines an interface for configuration creation operations.
 */
interface FeaturesConfigCreatedInterface {

  /**
   * Name of the event triggered at config created.
   */
  const CONFIG_CREATED = 'features_extended.config_created';

  /**
   * Creates configuration in a collection based on the provided list.
   *
   * @param array $config_to_create
   *   An array of configuration data to create, keyed by name.
   *
   * @return array
   *   An array of config imported:
   *     - 'new': list of new config created keyed by name.
   *     - 'updated': list of updated config keyed by name.
   */
  public function createConfiguration(array $config_to_create);

}
