<?php

namespace Drupal\workwise;

interface WorkWiseIntegrationManagerInterface {

  /**
   * Gets a array of active (or all) WorkWise integrations.
   *
   * @param bool $includeInactive
   *   Include inactive WorkWise integrations in the result.
   *
   * @return \Drupal\workwise\Entity\WorkWiseIntegrationInterface[]
   *   The WorkWise integration entities.
   */
  public function getIntegrations($includeInactive = FALSE);

  /**
   * Gets a single WorkWise integration by ID.
   *
   * @param $id
   *   The WorkWise integration ID.
   *
   * @return \Drupal\workwise\Entity\WorkWiseIntegrationInterface|NULL
   *   The WorkWise integration entity, or NULL if not found.
   */
  public function getIntegration($id);

}
