<?php

namespace Drupal\workwise\Form;

use Drupal\Core\Entity\EntityConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Form handler for the WorkWise connection delete form.
 */
class WorkWiseConnectionDeleteForm extends EntityConfirmFormBase {

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete WorkWise connection %label?', [
      '%label' => $this->entity->label()
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.workwise_connection.collection');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->entity->delete();

    drupal_set_message($this->t('WorkWise connection %label has been deleted.', [
      '%label' => $this->entity->label()
    ]));

    $form_state->setRedirectUrl($this->getCancelUrl());
  }

}
