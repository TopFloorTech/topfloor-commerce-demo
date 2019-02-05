<?php

namespace Drupal\workwise\Event;

use Drupal\workwise\Entity\WorkWiseIntegrationInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Defines the WorkWise integration event type used for WorkWise integration-related events.
 *
 * @see \Drupal\workwise\Event\WorkWiseEvents
 */
class WorkWiseIntegrationEvent extends Event {

  /**
   * The WorkWise integration.
   *
   * @var \Drupal\workwise\Entity\WorkWiseIntegrationInterface
   */
  protected $workWiseIntegration;

  /**
   * Constructs a new WorkWiseIntegrationEvent.
   *
   * @param \Drupal\workwise\Entity\WorkWiseIntegrationInterface $workWiseIntegration
   *   The WorkWise integration.
   */
  public function __construct(WorkWiseIntegrationInterface $workWiseIntegration) {
    $this->workWiseIntegration = $workWiseIntegration;
  }

  /**
   * Gets the WorkWise connection.
   *
   * @return \Drupal\workwise\Entity\WorkWiseIntegrationInterface
   *   The WorkWise integration.
   */
  public function getWorkWiseIntegration() {
    return $this->workWiseIntegration;
  }

}
