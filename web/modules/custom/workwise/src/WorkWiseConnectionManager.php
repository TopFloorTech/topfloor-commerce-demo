<?php

namespace Drupal\workwise;

use Drupal\Core\Entity\EntityTypeManagerInterface;

class WorkWiseConnectionManager implements WorkWiseConnectionManagerInterface {

  /** @var EntityTypeManagerInterface */
  protected $entityTypeManager;

  /** @var \Drupal\Core\Entity\EntityStorageInterface */
  protected $storage;

  /**
   * SearchSuggesterManager constructor.
   *
   * @param EntityTypeManagerInterface $entityTypeManager
   *   The entity type manager.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function __construct(EntityTypeManagerInterface $entityTypeManager)
  {
    $this->entityTypeManager = $entityTypeManager;
    $this->storage = $entityTypeManager->getStorage('workwise_connection');
  }

  /**
   * {@inheritdoc}
   */
  public function getConnections($includeInactive = FALSE)
  {
    $properties = [];
    if (!$includeInactive) {
      $properties['enabled'] = TRUE;
    }

    return $this->entityTypeManager->getStorage('workwise_connection')->loadByProperties($properties);
  }

  /**
   * {@inheritdoc}
   */
  public function getConnection($id)
  {
    return $this->entityTypeManager->getStorage('workwise_connection')->load($id);
  }

}
