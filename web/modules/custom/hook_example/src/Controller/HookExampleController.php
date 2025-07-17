<?php

namespace Drupal\hook_example\Controller;

use Drupal\Core\Controller\ControllerBase;
/**
 * This HookExampleController class wil show the welcome message via routing help of the content method.
 */
class HookExampleController extends ControllerBase {

/**
 * Returns the render array for the custom welcome page.
 *
 * @return array
 *   A render array containing a translated welcome message.
 */
public function content() {
  return [
    '#markup' => $this->t('Welcome to the Hook Example Demo page!'),
  ];
}
}
