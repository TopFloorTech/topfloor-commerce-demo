<?php

namespace Drupal\workwise;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\workwise\Annotation\WorkWiseConnectionPlugin;
use Drupal\workwise\Plugin\WorkWiseConnection\WorkWiseConnectionPluginInterface;

/**
 * Provides a plugin manager for WorkWise connection plugins.
 */
class WorkWiseConnectionPluginManager extends DefaultPluginManager {

  /**
   * Constructs a new WOrkWiseConnectionPluginManager.
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
    parent::__construct('Plugin/WorkWiseConnection', $namespaces, $module_handler, WorkWiseConnectionPluginInterface::class, WorkWiseConnectionPlugin::class);

    $this->setCacheBackend($cache_backend, 'search_suggester_display');
    $this->alterInfo('search_suggester_display');
  }

  public function getAllPlugins(array $configuration) {
    $definitions = $this->getDefinitions();

    $plugins = [];

    foreach ($definitions as $id => $definition) {
      $plugins[$id] = $this->createInstance($id, $configuration[$id]);
    }

    return $plugins;
  }

}
