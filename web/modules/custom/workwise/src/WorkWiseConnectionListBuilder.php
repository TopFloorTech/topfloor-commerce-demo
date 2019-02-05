<?php

namespace Drupal\workwise;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * The list builder for search suggester entities.
 */
class WorkWiseConnectionListBuilder extends ConfigEntityListBuilder {
  public function buildHeader() {
    $header = [
      'label' => $this->t('Label'),
      'id' => $this->t('Machine name'),
      'company' => $this->t('Company'),
      'username' => $this->t('Username'),
      'enabled' => $this->t('Enabled'),
    ];

    return $header + parent::buildHeader();
  }

  public function buildRow(EntityInterface $entity) {
    /** @var \Drupal\workwise\Entity\WorkWiseConnectionInterface $entity */

    $row = [
      'label' => $entity->label(),
      'id' => $entity->id(),
      'company' => $entity->getCompany(),
      'username' => $entity->getUsername(),
      'enabled' => $entity->isEnabled() ? $this->t('Yes') : $this->t('No'),
    ];

    return $row + parent::buildRow($entity);
  }

}
