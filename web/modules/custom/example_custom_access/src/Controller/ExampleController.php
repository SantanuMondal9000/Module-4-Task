<?php

namespace Drupal\example_custom_access\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Controller for custom access example.
 */
class ExampleController extends ControllerBase {

  /**
   * The content function will return the welcome message in the page.
   */
  public function content() {
    return [
      '#markup' => $this->t('Welcome to the custom access page.'),
    ];
  }

 

}
