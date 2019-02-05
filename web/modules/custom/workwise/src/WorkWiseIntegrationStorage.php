<?php

namespace Drupal\workwise;

use Drupal\Core\Config\Entity\ConfigEntityStorage;

/**
 * Defines the WorkWise integration storage.
 */
class WorkWiseIntegrationStorage extends ConfigEntityStorage implements WorkWiseIntegrationStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function loadValid() {
    $query = $this->getQuery()
      ->condition('enabled', 1);

    $result = $query->execute();

    if (empty($result)) {
      return [];
    }

    return $this->loadMultiple($result);
  }

}
