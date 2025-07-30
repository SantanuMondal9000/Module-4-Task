<?php

namespace Drupal\award_movies;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;

/**
 * Provides a listing of award movies in a table format in the collection page.
 */
final class AwardMoviesListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader(): array {
    $header['label'] = $this->t('Label');
    $header['award_name'] = $this->t('Award Name');
    $header['award_year'] = $this->t('Award Year');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity): array {
    /** @var \Drupal\award_movies\AwardMoviesInterface $entity */
    $row['label'] = $entity->label();
    $row['award_name'] = $entity->get('award_name');
    $row['award_year'] = $entity->get('award_year');
    return $row + parent::buildRow($entity);
  }

}
