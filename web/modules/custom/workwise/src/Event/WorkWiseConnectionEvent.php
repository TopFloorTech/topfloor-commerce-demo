<?php

namespace Drupal\workwise\Event;

use Drupal\workwise\Entity\WorkWiseConnectionInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Defines the WorkWise connection event type used for WorkWise connection-related events.
 *
 * @see \Drupal\workwise\Event\WorkWiseEvents
 */
class WorkWiseConnectionEvent extends Event {

  /**
   * The WorkWise connection.
   *
   * @var \Drupal\workwise\Entity\WorkWiseConnectionInterface
   */
  protected $workWiseConnection;

  /**
   * Constructs a new WorkWiseConnectionEvent.
   *
   * @param \Drupal\workwise\Entity\WorkWiseConnectionInterface $workWiseConnection
   *   The WorkWise connection.
   */
  public function __construct(WorkWiseConnectionInterface $workWiseConnection) {
    $this->workWiseConnection = $workWiseConnection;
  }

  /**
   * Gets the WorkWise connection.
   *
   * @return \Drupal\workwise\Entity\WorkWiseConnectionInterface
   *   The WorkWise connection.
   */
  public function getWorkWiseConnection() {
    return $this->workWiseConnection;
  }

}
