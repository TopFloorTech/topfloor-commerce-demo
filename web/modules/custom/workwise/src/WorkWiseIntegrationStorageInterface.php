<?php

namespace Drupal\workwise;

use Drupal\Core\Config\Entity\ConfigEntityStorageInterface;

/**
 * Defines the interface for WorkWise integration storage.
 */
interface WorkWiseIntegrationStorageInterface extends ConfigEntityStorageInterface {

  /**
   * Loads the valid WorkWise integration config entities.
   *
   * @return \Drupal\workwise\Entity\WorkWiseIntegrationInterface[]
   *   The valid WorkWise integrations.
   */
  public function loadValid();

}
