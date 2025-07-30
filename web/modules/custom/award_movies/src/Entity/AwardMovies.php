<?php

namespace Drupal\award_movies\Entity;

use Drupal\award_movies\AwardMoviesInterface;
use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the award movies entity type.
 *
 * @ConfigEntityType(
 *   id = "award_movies",
 *   label = @Translation("Award Movies"),
 *   label_collection = @Translation("Award Moviess"),
 *   label_singular = @Translation("award movies"),
 *   label_plural = @Translation("award moviess"),
 *   label_count = @PluralTranslation(
 *     singular = "@count award movies",
 *     plural = "@count award moviess",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\award_movies\AwardMoviesListBuilder",
 *     "form" = {
 *       "add" = "Drupal\award_movies\Form\AwardMoviesForm",
 *       "edit" = "Drupal\award_movies\Form\AwardMoviesForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *   },
 *   config_prefix = "award_movies",
 *   admin_permission = "administer award_movies",
 *   links = {
 *     "collection" = "/admin/structure/award-movies",
 *     "add-form" = "/admin/structure/award-movies/add",
 *     "edit-form" = "/admin/structure/award-movies/{award_movies}",
 *     "delete-form" = "/admin/structure/award-movies/{award_movies}/delete",
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "award_name" = "award_name",
 *     "award_year" = "award_year"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "award_name",
 *     "award_year"
 *   },
 * )
 */
final class AwardMovies extends ConfigEntityBase implements AwardMoviesInterface {

  /**
   * The example ID.
   */
  protected string $id;

  /**
   * The example label.
   */
  protected string $label;

  /**
   * The example description.
   */
  protected string $description;

}
