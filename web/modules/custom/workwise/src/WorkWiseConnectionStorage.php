<?php

namespace Drupal\workwise;

use Drupal\Core\Config\Entity\ConfigEntityStorage;

/**
 * Defines the Search Suggester storage.
 */
class WorkWiseConnectionStorage extends ConfigEntityStorage implements WorkWiseConnectionStorageInterface {

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
