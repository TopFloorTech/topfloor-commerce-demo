<?php

namespace Drupal\workwise\Entity;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Defines the interface for WorkWise connection config entities.
 */
interface WorkWiseConnectionInterface extends ConfigEntityInterface {

  /**
   * Gets the WorkWise connection machine name.
   *
   * @return string
   *   The machine name.
   */
  public function getId();

  /**
   * Sets the WorkWise connection machine name.
   *
   * @param string $id
   *   The machine name.
   *
   * @return self
   */
  public function setId($id);

  /**
   * Gets the WorkWise connection label.
   *
   * @return string
   *   The label.
   */
  public function getLabel();

  /**
   * Sets the WorkWise connection label.
   *
   * @param string $label
   *   The label.
   *
   * @return self
   */
  public function setLabel($label);

  /**
   * Gets the WorkWise company.
   *
   * @return string
   *   The company.
   */
  public function getCompany();

  /**
   * Sets the WorkWise company.
   *
   * @param string $company
   *   The company.
   *
   * @return self
   */
  public function setCompany($company);

  /**
   * Gets the WorkWise username.
   *
   * @return string
   *   The username.
   */
  public function getUsername();

  /**
   * Sets the WorkWise username.
   *
   * @param string $username
   *   The username.
   *
   * @return self
   */
  public function setUsername($username);

  /**
   * Gets the WorkWise password.
   *
   * @return string
   *   The password.
   */
  public function getPassword();

  /**
   * Sets the WorkWise password.
   *
   * @param string $password
   *   The password.
   *
   * @return self
   */
  public function setPassword($password);

  /**
   * Gets the WorkWise connection plugin configuration.
   *
   * @return string
   *   The password.
   */
  public function getPluginConfiguration();

  /**
   * Sets the WorkWise connection plugin configuration.
   *
   * @param array $pluginConfiguration
   *   The plugin configuration.
   *
   * @return self
   */
  public function setPluginConfiguration(array $pluginConfiguration);

  /**
   * Get whether the WorkWise connection is enabled.
   *
   * @return bool
   *   TRUE if the WorkWise connection is enabled, FALSE otherwise.
   */
  public function isEnabled();

  /**
   * Sets whether the WorkWise connection is enabled.
   *
   * @param bool $enabled
   *   Whether the WorkWise connection is enabled.
   *
   * @return $this
   */
  public function setEnabled($enabled);

}
