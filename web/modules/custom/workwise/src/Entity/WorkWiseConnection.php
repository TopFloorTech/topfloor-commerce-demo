<?php

namespace Drupal\workwise\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines a WorkWise connection entity.
 *
 * @ConfigEntityType(
 *   id = "workwise_connection",
 *   label = @Translation("WorkWise connection"),
 *   handlers = {
 *     "list_builder" = "Drupal\workwise\WorkWiseConnectionListBuilder",
 *     "storage" = "Drupal\workwise\WorkWiseConnectionStorage",
 *     "form" = {
 *       "add" = "Drupal\workwise\Form\WorkWiseConnectionForm",
 *       "edit" = "Drupal\workwise\Form\WorkWiseConnectionForm",
 *       "delete" = "Drupal\workwise\Form\WorkWiseConnectionDeleteForm"
 *     }
 *   },
 *   config_prefix = "workwise_connection",
 *   admin_permission = "administer workwise",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label"
 *   },
 *   links = {
 *     "collection" = "/admin/config/services/workwise",
 *     "edit-form" = "/admin/config/services/workwise/{workwise_connection}",
 *     "delete-form" = "/admin/config/services/workwise/{workwise_connection}/delete"
 *   }
 * )
 */
class WorkWiseConnection extends ConfigEntityBase implements WorkWiseConnectionInterface {

  /**
   * The WorkWise connection machine name.
   *
   * @var string
   */
  public $id;

  /**
   * The WorkWise connection label.
   *
   * @var string
   */
  public $label;

  /**
   * The WorkWise company.
   *
   * @var string
   */
  public $company;

  /**
   * The WorkWise username.
   *
   * @var string
   */
  public $username;

  /**
   * The WorkWise password.
   *
   * @var string
   */
  public $password;

  /**
   * The connection plugin configuration.
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
  public function getCompany() {
    return $this->company;
  }

  /**
   * {@inheritdoc}
   */
  public function setCompany($company) {
    $this->company = $company;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getUsername() {
    return $this->username;
  }

  /**
   * {@inheritdoc}
   */
  public function setUsername($username) {
    $this->username = $username;
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * {@inheritdoc}
   */
  public function setPassword($password) {
    $this->password = $password;
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
  public function setPluginConfiguration(array $pluginConfiguration) {
    $this->plugin_configuration = $pluginConfiguration;
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
