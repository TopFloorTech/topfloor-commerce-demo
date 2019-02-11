<?php

namespace Drupal\workwise\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\workwise\Plugin\WorkWise\WorkWisePluginInterface;

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
   * The WorkWise connection ID.
   *
   * @var string
   */
  public $connection_id;

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
  public function getConnectionId() {
    return $this->connection_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setConnectionId($connectionId) {
    $this->connection_id = $connectionId;
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

  /**
   * {@inheritdoc}
   */
  public function isActive() {
    if (!$this->isEnabled()) {
      return FALSE;
    }

    $connection = $this->getConnection();

    if ($connection && !$connection->isEnabled()) {
      return FALSE;
    }

    /** @var \Drupal\workwise\WorkWisePluginManager $pluginManager */
    $pluginManager = \Drupal::service('plugin.manager.workwise');
    $pluginId = $this->getPluginId();

    return $pluginManager->validateRequirements($pluginId);
  }

  /**
   * {@inheritdoc}
   */
  public function getConnection() {
    /** @var \Drupal\workwise\WorkWiseConnectionManagerInterface $manager */
    $manager = \Drupal::service('workwise_connection.manager');
    return $manager->getConnection($this->getConnectionId());
  }

  /**
   * {@inheritdoc}
   */
  public function getPlugin() {
    $id = $this->getPluginId();
    $configuration = $this->getPluginConfiguration();

    $plugin = NULL;

    if (!empty($id)) {
      /** @var \Drupal\workwise\WorkWisePluginManager $pluginManager */
      $pluginManager = \Drupal::service('plugin.manager.workwise');
      $plugin = $pluginManager->createInstance($id, $configuration);
    }

    return $plugin;
  }

  /**
   * {@inheritdoc}
   */
  public function performOperation($operation, EntityInterface $entity = NULL) {
    /** @var \Drupal\workwise\Plugin\WorkWise\WorkWisePluginInterface $plugin */
    $plugin = $this->getPlugin();
    $connection = $this->getConnection();
    $apiRequest = NULL;

    if ($this->validateOperation($operation, $entity)) {
      $apiMethod = $plugin->getApiMethod($operation);
      $requestData = $plugin->prepareRequestData($operation, $entity);
      $apiRequest = $connection->sendRequest($apiMethod, $requestData);
    }

    return $apiRequest;
  }

  /**
   * {@inheritdoc}
   */
  public function validateOperation($operation, EntityInterface $entity = NULL) {
    /** @var \Drupal\workwise\Plugin\WorkWise\WorkWisePluginInterface $plugin */
    $plugin = $this->getPlugin();
    $connection = $this->getConnection();

    return ($this->isActive()
      && $connection
      && $connection->isEnabled()
      && $plugin
      && $plugin->validateRequirements()
      && $plugin->validateOperation($operation, $entity));
  }

  /**
   * {@inheritdoc}
   */
  public function remoteRecordExists(EntityInterface $entity) {
    $plugin = $this->getPlugin();
    $exists = FALSE;

    if ($plugin instanceof WorkWisePluginInterface) {
      $remoteId = $plugin->getRemoteId($entity);
      $exists = !empty($remoteId);
    }

    return $exists;
  }
}
