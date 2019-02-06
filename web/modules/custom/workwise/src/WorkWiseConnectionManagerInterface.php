<?php

namespace Drupal\workwise;

interface WorkWiseConnectionManagerInterface {

  /**
   * Gets a array of active (or all) WorkWise connections.
   *
   * @param bool $includeInactive
   *   Include inactive WorkWise connections in the result.
   *
   * @return \Drupal\workwise\Entity\WorkWiseConnectionInterface[]
   *   The WorkWise connection entities.
   */
  public function getConnections($includeInactive = FALSE);

  /**
   * Gets a single WorkWise connection by ID.
   *
   * @param $id
   *   The WorkWise connection ID.
   *
   * @return \Drupal\workwise\Entity\WorkWiseConnectionInterface|NULL
   *   The WorkWise connection entity, or NULL if not found.
   */
  public function getConnection($id);

  /**
   * Gets an array of connection titles, keyed by ID, of all active connections.
   *
   * @return string[]
   *   The connection titles, keyed by ID.
   */
  public function getConnectionOptions();

}
