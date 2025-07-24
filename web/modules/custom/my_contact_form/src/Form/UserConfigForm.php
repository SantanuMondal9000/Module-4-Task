<?php

namespace Drupal\my_contact_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a configuration form to store user information.
 */
class UserConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   *
   * Returns the unique form ID.
   *
   * @return string
   *   The form ID.
   */
  public function getFormId() {
    return 'custom_user_config_form';
  }

  /**
   * {@inheritdoc}
   *
   * Returns the editable config names for this form.
   *
   * @return array
   *   An array of config object names that are editable.
   */
  protected function getEditableConfigNames() {
    return ['custom_user_config.settings'];
  }

  /**
   * {@inheritdoc}
   *
   * Builds the configuration form.
   *
   * @param array $form
   *   The form structure.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('custom_user_config.settings');

    $form['full_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Full Name'),
      '#required' => TRUE,
      '#default_value' => $config->get('full_name'),
    ];

    $form['phone_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone Number'),
      '#required' => TRUE,
      '#default_value' => $config->get('phone_number'),
    ];

    $form['email_id'] = [
      '#type' => 'email',
      '#title' => $this->t('Email ID'),
      '#required' => TRUE,
      '#default_value' => $config->get('email_id'),
    ];

    $form['gender'] = [
      '#type' => 'radios',
      '#title' => $this->t('Gender'),
      '#options' => [
        'male' => $this->t('Male'),
        'female' => $this->t('Female'),
        'other' => $this->t('Other'),
      ],
      '#default_value' => $config->get('gender') ?: 'male',
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   *
   * Validates form input.
   *
   * @param array $form
   *   The form structure.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Phone validation: Indian 10-digit numbers starting with 6-9.
    $phone = $form_state->getValue('phone_number');
    if (!preg_match('/^[6-9][0-9]{9}$/', $phone)) {
      $form_state->setErrorByName('phone_number', $this->t('Please enter a valid 10-digit Indian phone number starting with 6-9.'));
    }

    // Email validation with domain and TLD check.
    $email = $form_state->getValue('email_id');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $form_state->setErrorByName('email_id', $this->t('The email must be a valid RFC email address.'));
    }
    else {
      $allowed_domains = ['gmail.com', 'yahoo.com', 'outlook.com', 'hotmail.com'];
      $domain = strtolower(substr(strrchr($email, "@"), 1));

      if (!in_array($domain, $allowed_domains)) {
        $form_state->setErrorByName('email_id', $this->t('Only public domains like Gmail, Yahoo, Outlook are allowed.'));
      }

      if (!str_ends_with($email, '.com')) {
        $form_state->setErrorByName('email_id', $this->t('Only .com email addresses are allowed.'));
      }
    }

    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   *
   * Submits the form and saves configuration.
   *
   * @param array $form
   *   The form structure.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('custom_user_config.settings')
      ->set('full_name', $form_state->getValue('full_name'))
      ->set('phone_number', $form_state->getValue('phone_number'))
      ->set('email_id', $form_state->getValue('email_id'))
      ->set('gender', $form_state->getValue('gender'))
      ->save();

    parent::submitForm($form, $form_state);
    $this->messenger()->addMessage($this->t('User information saved successfully.'));
  }
}
