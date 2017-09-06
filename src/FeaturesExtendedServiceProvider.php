<?php

namespace Drupal\features_extended;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\DependencyInjection\ServiceProviderBase;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Defines a Service Provider class for altering existing services.
 */
class FeaturesExtendedServiceProvider extends ServiceProviderBase {

  /**
   * {@inheritdoc}
   */
  public function alter(ContainerBuilder $container) {
    // Update the Features module's features.manager service definition to make
    // use of our own and attach a new argument which references the event
    // dispatcher service.
    $definition = $container->getDefinition('features.manager');
    $definition->setClass('Drupal\features_extended\FeaturesManager');
    $arguments = $definition->getArguments();
    $arguments[] = new Reference('event_dispatcher');
    $definition->setArguments($arguments);
    $container->setDefinition('features.manager', $definition);
  }

}
