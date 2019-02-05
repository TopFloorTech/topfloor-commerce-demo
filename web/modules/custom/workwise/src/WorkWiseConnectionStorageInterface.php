<?php

namespace Drupal\workwise;

use Drupal\Core\Config\Entity\ConfigEntityStorageInterface;

/**
 * Defines the interface for search suggester storage.
 */
interface WorkWiseConnectionStorageInterface extends ConfigEntityStorageInterface {

  /**
   * Loads the valid search suggester config entities.
   *
   * @return \Drupal\workwise\Entity\WorkWiseConnectionInterface[]
   *   The valid search suggesters.
   */
  public function loadValid();

}
