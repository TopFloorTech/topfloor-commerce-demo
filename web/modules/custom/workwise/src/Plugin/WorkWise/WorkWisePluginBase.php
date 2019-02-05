<?php

namespace Drupal\workwise\Plugin\WorkWiseConnection;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContextAwarePluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

abstract class WorkWisePluginBase extends ContextAwarePluginBase implements WorkWisePluginInterface {

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
