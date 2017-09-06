<?php

/**
 * @file
 * Provides drush commands for the Features Extended module.
 */

use Drupal\features\FeaturesManagerInterface;

/**
 * Implements hook_drush_command().
 */
function features_extended_drush_command() {
  $commands = [];
  $commands['features-extended-import-all'] = [
    'description' => 'Import module configuration from all installed features.',
  ];
  return $commands;
}

/**
 * Callback for `features-extended-import-all` drush command.
 */
function drush_features_extended_import_all() {
  $assigner = _drush_features_options();
  $current_bundle = $assigner->getBundle();
  $namespace = $current_bundle->isDefault() ? '' : $current_bundle->getMachineName();

  /** @var \Drupal\features\FeaturesManagerInterface $manager */
  $manager = \Drupal::service('features.manager');
  $packages = $manager->getPackages();
  $packages = $manager->filterPackages($packages, $namespace);

  $package_machine_names = [];
  foreach ($packages as $package) {
    if ($package->getStatus() == FeaturesManagerInterface::STATUS_INSTALLED) {
      $package_machine_names[] = $package->getMachineName();
    }
  }

  if (!empty($package_machine_names)) {
    drush_set_option('force', TRUE);
    call_user_func_array('drush_features_import', $package_machine_names);
  }
}
