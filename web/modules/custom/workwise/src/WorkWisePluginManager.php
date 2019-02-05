<?php

namespace Drupal\workwise;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\workwise\Annotation\WorkWisePlugin;
use Drupal\workwise\Plugin\WorkWiseConnection\WorkWisePluginInterface;

/**
 * Provides a plugin manager for WorkWise plugins.
 */
class WorkWisePluginManager extends DefaultPluginManager {

  /**
   * Constructs a new WorkWisePluginManager.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/WorkWise', $namespaces, $module_handler, WorkWisePluginInterface::class, WorkWisePlugin::class);

    $this->setCacheBackend($cache_backend, 'workwise_plugin');
    $this->alterInfo('workwise_plugin');
  }

}
