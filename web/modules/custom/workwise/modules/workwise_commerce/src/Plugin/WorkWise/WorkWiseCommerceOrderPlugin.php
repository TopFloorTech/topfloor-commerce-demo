<?php

namespace Drupal\workwise_commerce\Plugin\WorkWise;

use Drupal\Core\Annotation\ContextDefinition;
use Drupal\Core\Annotation\Translation;
use Drupal\workwise\Annotation\WorkWisePlugin;
use Drupal\workwise\Plugin\WorkWiseConnection\WorkWisePluginBase;

/**
 * Provides a 'Commerce order' WorkWise plugin.
 *
 * @WorkWisePlugin(
 *   id = "commerce_order",
 *   label = @Translation("Commerce order"),
 *   context = {
 *     "workwise_integration" = @ContextDefinition("entity:workwise_integration", label = @Translation("WorkWise integration"))
 *   }
 * )
 */
class WorkWiseCommerceOrderPlugin extends WorkWisePluginBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state)
  {
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state)
  {
  }

}
