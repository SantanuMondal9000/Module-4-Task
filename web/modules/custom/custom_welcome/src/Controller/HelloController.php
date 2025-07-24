<?php

namespace Drupal\custom_welcome\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\custom_welcome\Service\WelcomeMessageService;

class HelloController extends ControllerBase {

  /**
   * Our custom welcome message service.
   *
   * @var \Drupal\custom_welcome\Service\WelcomeMessageService
   */
  protected $welcomeMessage;

  /**
   * Inject the WelcomeMessageService.
   */
  public function __construct(WelcomeMessageService $welcomeMessage) {
    $this->welcomeMessage = $welcomeMessage;
  }

  /**
   * Factory method for the controller.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('custom_welcome.welcome_message')
    );
  }

  /**
   * Controller method to return the welcome message.
   */
  public function hello() {
    return $this->welcomeMessage->getWelcomeMessage();
  }
}
