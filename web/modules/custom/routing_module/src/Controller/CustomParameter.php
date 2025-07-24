<?php

namespace Drupal\routing_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * The CustomParameter class will show the is pass by url parameter.
 */
class CustomParameter extends ControllerBase {
  /**
   * Print the current id from the url.
   * 
   * @param string $id
   *   The id parameter from the routing url.
   */
  public function showId($id) {
    return [
      '#markup' => $this->t('The Value of the id is @id', ['@id' => $id]),
    ];
  }
}
