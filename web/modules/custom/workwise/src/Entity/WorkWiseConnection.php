<?php

namespace Drupal\workwise\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\workwise\WorkWise\ApiRequest\ApiRequest;

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
 *     "collection" = "/admin/config/services/workwise/connections",
 *     "edit-form" = "/admin/config/services/workwise/connections/{workwise_connection}",
 *     "delete-form" = "/admin/config/services/workwise/connections/{workwise_connection}/delete"
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
   * The WorkWise connection URL.
   *
   * @var string
   */
  public $url;

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
   * Whether this connection is in dry run mode.
   *
   * @var bool
   */
  public $dry_run;

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
  public function getUrl() {
    return $this->url;
  }

  /**
   * {@inheritdoc}
   */
  public function setUrl($url) {
    $this->url = $url;
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
  public function sendRequest($apiMethod, array $data = []) {
    if (!$this->validateConnection()) {
      return NULL;
    }

    $request = new ApiRequest($this->getConnectionInfo(), $apiMethod, $data);
    $request->setDryRun($this->isDryRun());

    $textToAppend = $this->isDryRun() ? ' (Dry run)' : '';

    \Drupal::logger('workwise')->debug("WorkWise API Request$textToAppend:\n\n" . $request->debugRequestInfo());
    $request->sendRequest();
    \Drupal::logger('workwise')->debug("WorkWise API Response$textToAppend:\n\n" . $request->debugResponseInfo());

    return $request;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConnection() {
    $connectionInfo = $this->getConnectionInfo();
    $url = $this->getUrl();

    return $this->isEnabled()
      && !empty($connectionInfo)
      && !empty($url);
  }

  /**
   * {@inheritdoc}
   */
  public function getConnectionInfo() {
    $connectionInfo = [];

    if ($this->getUrl()) {
      $connectionInfo['url'] = $this->getUrl();
    }

    if ($this->getCompany()) {
      $connectionInfo['company'] = $this->getCompany();
    }

    if ($this->getUsername()) {
      $connectionInfo['username'] = $this->getUsername();
    }

    if ($this->getPassword()) {
      $connectionInfo['password'] = $this->getPassword();
    }

    return $connectionInfo;
  }

  /**
   * {@inheritdoc}
   */
  public function isDryRun() {
    return $this->dry_run;
  }

  /**
   * {@inheritdoc}
   */
  public function setDryRun($dryRun) {
    $this->dry_run = $dryRun;
    return $this;
  }

}
