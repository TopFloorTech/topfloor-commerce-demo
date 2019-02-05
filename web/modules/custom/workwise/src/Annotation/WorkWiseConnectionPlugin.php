<?php

namespace Drupal\workwise\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a WorkWise connection plugin.
 *
 * @Annotation
 */
class WorkWiseConnectionPlugin extends Plugin {

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

}
