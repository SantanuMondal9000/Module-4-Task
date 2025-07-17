<?php
namespace Drupal\welcome_block\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * This class will show the welcome message.
 */
class WelcomePageController extends ControllerBase {

  /**
   * content() will show the welcome message in the page.
   */
  public function content() {
    return [
      '#markup' => '<h2>This is the custom welcome page.</h2>',
    ];
  }
}

?>
