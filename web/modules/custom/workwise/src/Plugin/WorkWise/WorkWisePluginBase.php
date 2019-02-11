<?php

namespace Drupal\workwise\Plugin\WorkWise;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContextAwarePluginBase;
use Drupal\workwise\WorkWise\ApiRequest\ApiRequestInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class WorkWisePluginBase extends ContextAwarePluginBase implements WorkWisePluginInterface {

  protected $configurationFormStateKey = 'workwise_plugin';
  protected $remoteIdField = 'field_workwise_id';

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configuration += $this->defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function getConfiguration()
  {
    return $this->configuration;
  }

  /**
   * {@inheritdoc}
   */
  public function setConfiguration(array $configuration)
  {
    $this->configuration = $configuration;
  }

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
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public function calculateDependencies()
  {
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function label()
  {
    return $this->pluginDefinition['label'];
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription()
  {
    return isset($this->pluginDefinition['description']) ? $this->pluginDefinition['description'] : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function getRequirements()
  {
    return isset($this->pluginDefinition['requirements']) ? $this->pluginDefinition['requirements'] : [];
  }

  /**
   * {@inheritdoc}
   */
  public function getEntityTypeId() {
    return isset($this->pluginDefinition['entity_type']) ? $this->pluginDefinition['entity_type'] : NULL;
  }

  /**
   * {@inheritdoc}
   */
  public function validateRequirements()
  {
    /** @var \Drupal\workwise\WorkWisePluginManager $manager */
    $manager = $this->typedDataManager;
    return $manager->validateRequirements($this->pluginId);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfigurationFormStateKey() {
    return $this->configurationFormStateKey;
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
    return [];
  }

  /**
   * {@inheritdoc}
   */
  public function getApiMethod($operation = 'read') {
    $methods = $this->getApiMethods();

    if (!array_key_exists($operation, $methods)) {
      return NULL;
    }

    return $methods[$operation];
  }

  protected function getValue($key, $values) {
    $defaults = $this->defaultConfiguration();

    $value = '';

    if (isset($values[$key])) {
      $value = $values[$key];
    } elseif (isset($defaults[$key])) {
      $value = $defaults[$key];
    }

    return $value;
  }

  /**
   * {@inheritdoc}
   */
  abstract public function getOperationDefinitions();

  /**
   * {@inheritdoc}
   */
  abstract public function prepareRequestData($operation, EntityInterface $entity = NULL);

  /**
   * {@inheritdoc}
   */
  abstract public function handleResponse($operation, ApiRequestInterface $request, EntityInterface $entity = NULL);

  /**
   * {@inheritdoc}
   */
  public function validateOperation($operation, EntityInterface $entity = NULL) {
    $apiMethod = $this->getApiMethod($operation);
    return !empty($apiMethod);
  }

  /**
   * {@inheritdoc}
   */
  public function getRemoteId(EntityInterface $entity) {
    $remoteId = NULL;

    if ($entity instanceof FieldableEntityInterface
      && $entity->hasField($this->remoteIdField)
      && !$entity->get($this->remoteIdField)->isEmpty()) {
      $remoteId = $entity->get($this->remoteIdField)->value;
    }

    return $remoteId;
  }

}
