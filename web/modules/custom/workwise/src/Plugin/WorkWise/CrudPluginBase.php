<?php

namespace Drupal\workwise\Plugin\WorkWise;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Form\FormStateInterface;

abstract class CrudPluginBase extends WorkWisePluginBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    $allowedOperations = [];
    $definitions = $this->getOperationDefinitions();

    foreach ($definitions as $operation => $title) {
      $allowedOperations[] = $operation;
    }

    return [
      'allowed_operations' => $allowedOperations,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    $operations = $this->getOperationDefinitions();
    $options = [];

    foreach ($operations as $operation => $title) {
      $options[$operation] = $this->t($title);
    }

    $form['allowed_operations'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Allowed actions'),
      '#description' => $this->t('Choose which actions this integration should be allowed to perform.'),
      '#options' => $options,
      '#default_value' => $this->getValue('allowed_operations', $this->getConfiguration()),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state)
  {
    $values = $form_state->getValue($this->getConfigurationFormStateKey(), []);
    $this->configuration['allowed_operations'] = $this->getValue('allowed_operations', $values);
  }

  /**
   * {@inheritdoc}
   */
  public function getOperationDefinitions() {
    return [
      'create' => 'Create WorkWise records.',
      'read' => 'Read data from the WorkWise API.',
      'update' => 'Update existing WorkWise records.',
      'delete' => 'Delete existing WorkWise records.',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getApiMethods() {
    $apiMethods = [];

    foreach ($this->getOperationDefinitions() as $operation => $title) {
      $apiMethods[$operation] = NULL;
    }

    return $apiMethods;
  }

  /**
   * {@inheritdoc}
   */
  public function validateOperation($operation, EntityInterface $entity = NULL) {
    $configuration = $this->getConfiguration();
    $allowedOperations = $configuration['allowed_operations'];

    return in_array($operation, $allowedOperations, TRUE);
  }

}
