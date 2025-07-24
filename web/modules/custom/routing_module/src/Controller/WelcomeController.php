<?php

namespace Drupal\routing_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Welcome Controller class will show the welcome message by the content method.
 */
class WelcomeController extends ControllerBase {

  /**
   * The content function will return the welcome message in the page.
   */
  public function content() {
    return [
      '#markup' => $this->t('Welcome to the custom access page.'),
    ];
  }
}
