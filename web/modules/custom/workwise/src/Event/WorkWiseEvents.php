<?php

namespace Drupal\workwise\Event;

final class WorkWiseEvents {

  /**
   * Name of the event fired before connecting to a WorkWise connection.
   *
   * @Event
   *
   * @see \Drupal\workwise\Event\WorkWiseConnectionEvent
   */
  const BEFORE_CONNECT = 'workwise.before_connect';

}
