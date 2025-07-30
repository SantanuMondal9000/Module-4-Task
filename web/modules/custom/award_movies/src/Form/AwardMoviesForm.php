<?php

namespace Drupal\award_movies\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\award_movies\Entity\AwardMovies;

/**
 * Award Movies form will create the form to the user for submit the configuration details of the movie content type.
 */
final class AwardMoviesForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state): array {

    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => [AwardMovies::class, 'load'],
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['status'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enabled'),
      '#default_value' => $this->entity->status(),
    ];

    $form['award_name'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Award Name'),
      '#default_value' => $this->entity->get('award_name'),
    ];

    $form['award_year'] = [
      '#type' => 'number',
      '#title' => $this->t('Award Year'),
      '#default_value' => $this->entity->get('award_year'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state): int {
    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $this->messenger()->addStatus(
      match($result) {
        \SAVED_NEW => $this->t('Created new example %label.', $message_args),
        \SAVED_UPDATED => $this->t('Updated example %label.', $message_args),
      }
    );
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}
