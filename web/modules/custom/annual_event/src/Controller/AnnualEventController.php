<?php

namespace Drupal\annual_event\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Connection;

/**
 * Returns responses for Annual event routes.
 */
final class AnnualEventController extends ControllerBase {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Constructs a new EventController object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection service.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create($container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * This will return the count of the event per year.
   */
  public function getCountOfPerYearEvent() {
    $query = $this->database->select('node__field_date', 'ed');
    $query->addExpression('YEAR(ed.field_date_value)', 'year');
    $query->addExpression('COUNT(*)', 'total');
    $query->innerJoin('node_field_data', 'nfd', 'nfd.nid = ed.entity_id');
    $query->condition('nfd.type', 'event');
    $query->condition('nfd.status', 1);
    $query->groupBy('year');
    $query->orderBy('year', 'ASC');
    return $query->execute()->fetchAllAssoc('year');
  }

  /**
   * This will return a year event data in a table format.
   */
  public function eventReportTable() {
    $result = $this->getCountOfPerYearEvent();
    $rows = [];

    foreach ($result as $record) {
      $rows[] = [
        'data' => [$record->year, $record->total],
      ];
    }
    $header = [
      ['data' => $this->t('Year')],
      ['data' => $this->t('Total Events')],
    ];

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No Events Found'),
      '#prefix' => '<h2>' . $this->t('Event Per Year') . '</h2>',
    ];
  }

  /**
   * This function will return the quater table details.
   */
  public function getQuarterDetails() {
    $query = $this->database->select('node__field_date', 'ed');
    $query->addExpression('YEAR(ed.field_date_value)', 'year');
    $query->addExpression('QUARTER(ed.field_date_value)', 'quarter');
    $query->addExpression('COUNT(*)', 'total');
    $query->innerJoin('node_field_data', 'nfd', 'nfd.nid = ed.entity_id');
    $query->condition('nfd.type', 'event');
    $query->condition('nfd.status', 1);
    $query->groupBy('year');
    $query->groupBy('quarter');
    $query->orderBy('year', 'ASC');
    $query->orderBy('quarter', 'ASC');
    return $query->execute()->fetchAll();
  }

  /**
   * This will return the quarter table.
   */
  public function eventQuarterReportTable() {
    $result = $this->getQuarterDetails();
    $rows = [];
    $previous_year = NULL;

    foreach ($result as $record) {
      $year = (int) $record->year;

      $rows[] = [
        'data' => [
          $year === $previous_year ? '' : $year,
          'Q' . (int) $record->quarter,
          (int) $record->total,
        ],
      ];

      $previous_year = $year;
    }
    $header = [
    ['data' => $this->t('Year')],
    ['data' => $this->t('Quarter')],
    ['data' => $this->t('Total Events')],
    ];
    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No Events Found'),
      '#prefix' => '<h2>' . $this->t('Quarter Event Report') . '</h2>',
    ];
  }

  /**
   * This will return the data of each event type number.
   */
  public function getEventTypeDetails() {
    $query = $this->database->select('node__field_event_type', 'et');
    $query->addExpression('COUNT(*)', 'total');
    $query->join('taxonomy_term_field_data', 'tfd', 'tfd.tid = et.field_event_type_target_id');
    $query->condition('tfd.vid', "event_type");
    $query->addField('tfd', 'name', 'name');
    $query->groupBy('tfd.name');
    $query->orderBy('tfd.name', 'ASC');
    return $query->execute()->fetchAll();
  }

  /**
   * This will return a year event data in a table format.
   */
  public function eventTypeTable() {
    $result = $this->getEventTypeDetails();
    $rows = [];

    foreach ($result as $record) {
      $rows[] = [
        'data' => [$record->name, $record->total],
      ];
    }
    $header = [
      ['data' => $this->t('Event Name')],
      ['data' => $this->t('Total Events')],
    ];

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No Events Found'),
      '#prefix' => '<h2>' . $this->t('Event Per Type') . '</h2>',
    ];
  }

  /**
   * This function will display the all table.
   */
  public function dashboardContent() {
    return [
      '#type' => 'container',
      'countTable' => $this->eventReportTable(),
      'quarterTable' => $this->eventQuarterReportTable(),
      'eventTable' => $this->eventTypeTable(),
      '#cache' => [
        'tags' => ['node_list:event', 'taxonomy_term_list:event_type'],
      ],
    ];
  }

}
