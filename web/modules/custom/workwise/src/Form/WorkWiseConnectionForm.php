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
class WorkWiseConnectionForm extends EntityForm {

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
    $entity_query = $container->get('entity_type.manager')->getStorage('workwise_connection')->getQuery();

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

    /** @var \Drupal\workwise\Entity\WorkWiseConnectionInterface $workWiseConnection */
    $workWiseConnection = $this->entity;

    $form['#tree'] = TRUE;

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#description' => $this->t('Label for the WorkWise connection.'),
      '#default_value' => $workWiseConnection->label(),
      '#required' => TRUE,
      '#maxlength' => 255,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $workWiseConnection->getId(),
      '#machine_name' => [
        'exists' => [$this, 'exists'],
      ],
      '#disabled' => !$workWiseConnection->isNew(),
    ];

    $form['company'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Company'),
      '#description' => $this->t('The WorkWise company for authentication. This consists of 3 lower-case letters.'),
      '#default_value' => $workWiseConnection->getCompany(),
      '#required' => TRUE,
      '#maxlength' => 3,
    ];

    $form['username'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Username'),
      '#description' => $this->t('The WorkWise username for authentication.'),
      '#default_value' => $workWiseConnection->getUsername(),
      '#required' => TRUE,
    ];

    $form['password'] = [
      '#type' => 'password',
      '#title' => $this->t('Password'),
      '#description' => $this->t('The WorkWise password for authentication. Only fill this out if you need to change it.'),
      '#default_value' => '',
      '#required' => empty($workWiseConnection->getPassword()),
    ];



    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#description' => $this->t('When enabled, this WorkWise connection will be live.'),
      '#default_value' => $workWiseConnection->isEnabled(),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    /** @var \Drupal\workwise\Entity\WorkWiseConnectionInterface $workWiseConnection */
    $workWiseConnection = $this->entity;

    $status = $workWiseConnection->save();

    if ($status) {
      drupal_set_message($this->t('Saved the %label WorkWise connection.', [
        '%label' => $workWiseConnection->label(),
      ]));
    }
    else {
      drupal_set_message($this->t('The %label WorkWise connection was not saved.', [
        '%label' => $workWiseConnection->label(),
      ]));
    }

    $form_state->setRedirect('entity.workwise_connection.collection');
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
   * Copies form values into the config entity.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *   The config entity.
   * @param array $form
   *   The form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state object.
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
    $entity->set('company', $values['company']);
    $entity->set('username', $values['username']);

    if (!empty($values['password'])) {
      $entity->set('password', $values['password']);
    }
  }

  protected function getPlugins(array $configuration) {
    /** @var \Drupal\workwise\WorkWiseConnectionPluginManager $pluginManager */
    $pluginManager = \Drupal::service('plugin.manager.workwise_connection');

    return $pluginManager->getAllPlugins($configuration);
  }

}
