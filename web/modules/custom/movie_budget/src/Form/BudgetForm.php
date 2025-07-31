<?php

namespace Drupal\movie_budget\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Movie budget settings for the movie content type.
 */
final class BudgetForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'movie_budget_budget';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['movie_budget.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['budget'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Budget'),
      '#default_value' => $this->config('movie_budget.settings')->get('budget'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('movie_budget.settings')
      ->set('budget', $form_state->getValue('budget'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
