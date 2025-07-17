<?php

namespace Drupal\example_custom_access\Controller;

use Drupal\Core\Controller\ControllerBase;

class CustomParameter extends ControllerBase {
  /**
   * Print the current id from the url.
   * 
   * @param $id 
   * The id parameter from the routing url.
   */
  public function showID($id) {
    return [
      '#markup' => $this->t('The Value of the id is @id', ['@id' => $id]),
    ];
  }
}
