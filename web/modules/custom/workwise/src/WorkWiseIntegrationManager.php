<?php

namespace Drupal\workwise;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\workwise\Plugin\WorkWise\WorkWisePluginInterface;

class WorkWiseIntegrationManager implements WorkWiseIntegrationManagerInterface {

  /** @var EntityTypeManagerInterface */
  protected $entityTypeManager;

  /** @var \Drupal\Core\Entity\EntityStorageInterface */
  protected $storage;

  /**
   * WorkWiseIntegrationManager constructor.
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
    $this->storage = $entityTypeManager->getStorage('workwise_integration');
  }

  /**
   * {@inheritdoc}
   */
  public function getIntegrations($includeInactive = FALSE)
  {
    $properties = [];
    if (!$includeInactive) {
      $properties['enabled'] = TRUE;
    }

    return $this->entityTypeManager->getStorage('workwise_integration')->loadByProperties($properties);
  }

  /**
   * {@inheritdoc}
   */
  public function getIntegration($id)
  {
    return $this->entityTypeManager->getStorage('workwise_integration')->load($id);
  }

  /**
   * {@inheritdoc}
   */
  public function getIntegrationsForEntityType($entityTypeId) {
    $integrations = [];

    foreach ($this->getIntegrations() as $integration) {
      $plugin = $integration->getPlugin();
      if ($plugin instanceof WorkWisePluginInterface && $plugin->getEntityTypeId() === $entityTypeId) {
        $integrations[$integration->id()] = $integration;
      }
    }

    return $integrations;
  }
}
