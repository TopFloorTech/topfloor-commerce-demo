<?php

namespace Drupal\workwise\Form;

use Drupal\Core\Entity\EntityFieldManager;
use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityWithPluginCollectionInterface;
use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form handler for corresponding reference add and edit forms.
 */
class WorkWiseIntegrationForm extends EntityForm {

  /** @var QueryInterface */
  protected $entityQuery;

  /** @var  EntityFieldManager */
  protected $fieldManager;

  /**
   * Constructs a WorkWiseConnectionForm object.
   *
   * @param QueryInterface $entity_query
   *   The entity query.
   *
   * @param \Drupal\Core\Entity\EntityFieldManager $field_manager
   *   The entity field manager.
   */
  public function __construct(QueryInterface $entity_query, EntityFieldManager $field_manager) {
    $this->entityQuery = $entity_query;
    $this->fieldManager = $field_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    /** @var QueryInterface $entity_query */
    $entity_query = $container->get('entity_type.manager')->getStorage('workwise_integration')->getQuery();

    /** @var EntityFieldManager $field_manager */
    $field_manager = $container->get('entity_field.manager');

    return new static(
      $entity_query,
      $field_manager
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $input = $form_state->getUserInput();

    /** @var \Drupal\workwise\Entity\WorkWiseIntegrationInterface $workWiseIntegration */
    $workWiseIntegration = $this->entity;

    $form['#tree'] = TRUE;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#description' => $this->t('Label for the WorkWise connection.'),
      '#default_value' => $workWiseIntegration->label(),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $workWiseIntegration->getId(),
      '#machine_name' => [
        'exists' => [$this, 'exists'],
      ],
      '#disabled' => !$workWiseIntegration->isNew(),
    ];

    $pluginId = (!empty($input['plugin_id'])) ? $input['plugin_id'] : $workWiseIntegration->getPluginId();
    if (empty($pluginId)) {
      $pluginId = NULL;
    }

    $pluginConfig = (!empty($input['plugin_configuration'])) ? $input['plugin_configuration'] : $workWiseIntegration->getPluginConfiguration();
    if (!is_array($pluginConfig)) {
      $pluginConfig = [];
    }

    $form['plugin_id'] = [
      '#type' => 'select',
      '#title' => $this->t('Integration type'),
      '#options' => $this->getPluginOptions(),
      '#default_value' => $pluginId,
    ];

    if (!empty($pluginId)) {
      /** @var \Drupal\workwise\WorkWisePluginManager $pluginManager */
      $pluginManager = \Drupal::service('plugin.manager.workwise');
      /** @var \Drupal\workwise\Plugin\WorkWiseConnection\WorkWisePluginInterface $plugin */
      $plugin = $pluginManager->createInstance($pluginId, $pluginConfig);
      $plugin->setContextValue('workwise_integration', $workWiseIntegration);

      $pluginConfiguration = [
        '#type' => 'fieldset',
        '#title' => $this->t('Plugin settings'),
      ];
      $form['plugin_configuration'] = $plugin->buildConfigurationForm($pluginConfiguration, $form_state);
    }

    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#description' => $this->t('When enabled, this WorkWise integration will be active if the connection it relies on is also active.'),
      '#default_value' => $workWiseIntegration->isEnabled(),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\workwise\Entity\WorkWiseIntegrationInterface $workWiseIntegration */
    $workWiseIntegration = $this->entity;

    $status = $workWiseIntegration->save();

    if ($status) {
      drupal_set_message($this->t('Saved the %label WorkWise integration.', [
        '%label' => $workWiseIntegration->label(),
      ]));
    }
    else {
      drupal_set_message($this->t('The %label WorkWise integration was not saved.', [
        '%label' => $workWiseIntegration->label(),
      ]));
    }

    $form_state->setRedirect('entity.workwise_integration.collection');
  }

  /**
   * Helper function to check whether a corresponding reference configuration entity exists.
   */
  public function exists($id) {
    $entity = $this->entityQuery
      ->condition('id', $id)
      ->execute();
    return (bool) $entity;
  }

  /**
   * {@inheritdoc}
   */
  protected function copyFormValuesToEntity(EntityInterface $entity, array $form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    if ($this->entity instanceof EntityWithPluginCollectionInterface) {
      // Do not manually update values represented by plugin collections.
      $values = array_diff_key($values, $this->entity->getPluginCollections());
    }

    /** @var \Drupal\workwise\Entity\WorkWiseConnectionInterface $entity */
    $entity->set('id', $values['id']);
    $entity->set('label', $values['label']);
    $entity->set('enabled', $values['enabled']);
    $entity->set('plugin_id', $values['plugin_id']);

    if (!empty($values['plugin_configuration'])) {
      /** @var \Drupal\workwise\WorkWisePluginManager $pluginManager */
      $pluginManager = \Drupal::service('plugin.manager.workwise');

      /** @var \Drupal\workwise\Plugin\WorkWiseConnection\WorkWisePluginInterface $plugin */
      $plugin = $pluginManager
        ->createInstance($values['plugin_id'])
        ->setContextValue('workwise_integration', $workWiseIntegration)
        ->submitConfigurationForm($form['plugin_configuration'], $form_state);

      $entity->set('plugin_configuration', $plugin->getConfiguration());
    }
  }

  protected function getPluginOptions() {
    /** @var \Drupal\workwise\WorkWisePluginManager $manager */
    $manager = \Drupal::service('plugin.manager.workwise');
    $plugins = $manager->getValidDefinitions();
    $options = [];

    foreach ($plugins as $id => $definition) {
      $options[$id] = $definition['label'];
    }

    return $options;
  }

}
