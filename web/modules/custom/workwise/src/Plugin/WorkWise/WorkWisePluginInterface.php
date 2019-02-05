<?php

namespace Drupal\workwise\Plugin\WorkWiseConnection;

use Drupal\Component\Plugin\ConfigurablePluginInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\ContextAwarePluginInterface;
use Drupal\Core\Plugin\PluginFormInterface;

/**
 * Represents a plugin for WorkWise connections.
 */
interface WorkWisePluginInterface extends ConfigurablePluginInterface, ContainerFactoryPluginInterface, ContextAwarePluginInterface, PluginFormInterface {

  /**
   * Retrieves the plugin's label.
   *
   * @return string
   *   The plugin's human-readable and translated label.
   */
  public function label();

  /**
   * Retrieves the plugin's description.
   *
   * @return string|null
   *   The plugin's translated description; or NULL if it has none.
   */
  public function getDescription();

  /**
   * Retrieves the plugin's requirements.
   *
   * @return array
   *   The requirements keyed by requirement type (e.g. "modules").
   */
  public function getRequirements();

  /**
   * Validates whether the requirements for this plugin have been met.
   *
   * @return bool
   *   TRUE if the requirements have been met, FALSE otherwise.
   */
  public function validateRequirements();

}
