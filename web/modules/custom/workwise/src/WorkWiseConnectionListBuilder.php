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
      'dry_run' => $this->t('Dry run'),
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
      'dry_run' => $this->boolText($entity->isDryRun()),
      'enabled' => $this->boolText($entity->isEnabled()),
    ];

    return $row + parent::buildRow($entity);
  }

  private function boolText($value) {
    return $value ? $this->t('Yes') : $this->t('No');
  }

}
