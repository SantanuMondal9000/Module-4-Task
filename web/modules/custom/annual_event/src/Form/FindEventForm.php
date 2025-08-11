<?php

namespace Drupal\annual_event\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Provides a Annual Event form.
 */
final class FindEventForm extends FormBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new EventController object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection service.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager service.
   */
  public function __construct(Connection $database, EntityTypeManagerInterface $entity_type_manager) {
    $this->database = $database;
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create($container) {
    return new static(
      $container->get('database'),
      $container->get('entity_type.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'annual_event_find_event';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {

    $form['term_id'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Message'),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {}

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {

    $event_type = $form_state->getValue('term_id');
    $results = $this->findEventTypeNode($event_type);

    if (empty($results)) {
      $this->messenger()->addStatus('No events found for the selected event type.');
      return;
    }

    foreach ($results as $row) {
      $node = $this->entityTypeManager->getStorage('node')->load($row->nid);
      $url = $node->toUrl()->toString();
      $message = "Event Title: {$row->title} | Term ID: {$row->tid} | UUID: {$row->uuid} | UUID: {$url}";
      $this->messenger()->addStatus($message);
    }
  }

  /**
   * This function will return the row of node according to the event type.
   */
  public function findEventTypeNode($event_type_name) {
    $query = $this->database->select('node__field_event_type', 'fet');
    $query->join('node_field_data', 'nfd', 'nfd.nid = fet.entity_id');
    $query->join('taxonomy_term_data', 'ntd', 'ntd.tid = fet.field_event_type_target_id');
    $query->join('taxonomy_term_field_data', 'ttfd', 'ttfd.tid = ntd.tid');
    $query->condition('nfd.type', 'event');
    $query->condition('ttfd.name', $event_type_name);
    $query->addField('ntd', 'tid');
    $query->addField('ntd', 'uuid');
    $query->addField('nfd', 'title');
    $query->addField('nfd', 'nid');

    return $query->execute()->fetchAll();
  }

}
