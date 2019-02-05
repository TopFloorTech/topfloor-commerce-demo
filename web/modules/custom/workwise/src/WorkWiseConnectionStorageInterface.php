<?php

namespace Drupal\workwise;

use Drupal\Core\Config\Entity\ConfigEntityStorageInterface;

/**
 * Defines the interface for WorkWise connection storage.
 */
interface WorkWiseConnectionStorageInterface extends ConfigEntityStorageInterface {

  /**
   * Loads the valid WorkWise connection config entities.
   *
   * @return \Drupal\workwise\Entity\WorkWiseConnectionInterface[]
   *   The valid WorkWise connections.
   */
  public function loadValid();

}
