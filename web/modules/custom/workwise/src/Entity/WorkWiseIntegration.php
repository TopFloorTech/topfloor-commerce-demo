<?php

namespace Drupal\workwise\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines a WorkWise connection entity.
 *
 * @ConfigEntityType(
 *   id = "workwise_integration",
 *   label = @Translation("WorkWise integration"),
 *   handlers = {
 *     "list_builder" = "Drupal\workwise\WorkWiseIntegrationListBuilder",
 *     "storage" = "Drupal\workwise\WorkWiseIntegrationStorage",
 *     "form" = {
 *       "add" = "Drupal\workwise\Form\WorkWiseIntegrationForm",
 *       "edit" = "Drupal\workwise\Form\WorkWiseIntegrationForm",
 *       "delete" = "Drupal\workwise\Form\WorkWiseIntegrationDeleteForm"
 *     }
 *   },
 *   config_prefix = "workwise_integration",
 *   admin_permission = "administer workwise",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
 *   links = {
 *     "collection" = "/admin/config/services/workwise/integrations",
 *     "edit-form" = "/admin/config/services/workwise/integrations/{workwise_integration}",
 *     "delete-form" = "/admin/config/services/workwise/integrations/{workwise_integration}/delete"
 *   }
 * )
 */
class WorkWiseIntegration extends ConfigEntityBase implements WorkWiseIntegrationInterface {

  /**
   * The WorkWise integration machine name.
   *
   * @var string
   */
  public $id;

  /**
   * The WorkWise integration label.
   *
   * @var string
   */
  public $label;

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $plugin_id;

  /**
   * The plugin configuration.
   *
   * @var array
   */
  public $plugin_configuration;

  /**
   * Whether or not this WorkWise connection is enabled.
   *
   * @var bool
   */
  public $enabled;

  /**
   * {@inheritdoc}
   */
  public function id() {
    return $this->id;
  }

  /**
   * {@inheritdoc}
   */
  public function getId() {
    return $this->id;
  }

  /**
   * {@inheritdoc}
   */
  public function setId($id) {
    $this->id = $id;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getLabel() {
    return $this->label;
  }

  /**
   * {@inheritdoc}
   */
  public function setLabel($label) {
    $this->label = $label;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginId() {
    return $this->plugin_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setPluginId($pluginId) {
    $this->plugin_id = $pluginId;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPluginConfiguration() {
    return $this->plugin_configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function setPluginConfiguration(array $configuration) {
    $this->plugin_configuration = $configuration;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isEnabled() {
    return $this->enabled;
  }

  /**
   * {@inheritdoc}
   */
  public function setEnabled($enabled) {
    $this->enabled = $enabled;
    return $this;
  }
}
