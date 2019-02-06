<?php

namespace Drupal\workwise_commerce\Plugin\WorkWise;

use Drupal\Core\Annotation\ContextDefinition;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\workwise\Annotation\WorkWisePlugin;
use Drupal\workwise\Plugin\WorkWise\WorkWisePluginBase;

/**
 * Provides a 'Commerce order' WorkWise plugin.
 *
 * @WorkWisePlugin(
 *   id = "commerce_order",
 *   label = @Translation("Commerce order"),
 *   requirements = {
 *     "modules" = {
 *       "commerce_order",
 *     },
 *   },
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

  /**
   * {@inheritdoc}
   */
  public function getApiMethods() {
    return [
      'create' => 'CreateCustomerOrder',
      'read' => NULL,
      'update' => NULL,
      'delete' => NULL,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function prepareRequestData(EntityInterface $entity, $operation = 'create') {
    $data = [];

    // @todo Convert order entity into CreateCustomerOrder structure

    return $data;
  }
}
