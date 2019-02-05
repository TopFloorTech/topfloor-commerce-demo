<?php

namespace Drupal\workwise\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a WorkWise plugin.
 *
 * @Annotation
 */
class WorkWisePlugin extends Plugin {

  /**
   * The plugin label.
   *
   * @var string
   *
   * @ingroup plugin_translatable
   */
  public $label;

  /**
   * The plugin description.
   *
   * @var string
   *
   * @ingroup plugin_translatable
   */
  public $description;

  /**
   * The requirements for this plugin to be active, in the format:
   *
   * [
   *   'modules' => [],
   * ]
   *
   * @var array
   */
  public $requirements;

}
