<?php

namespace Drupal\hook_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\hook_example\Service\CustomLoginService;

class LoginCountController extends ControllerBase {
  /**
   * My custom login service
   * 
   * @var Drupal\hook_example\Service\CustomLoginService
   */
  protected $customLogin;

  public function __construct(CustomLoginService $custom_login) {
    $this->customLogin = $custom_login;
  }

  public static function create(ContainerInterface $container){
    return new static (
      $container->get('hook_example.login_details_service')
    );
  }

  /**
   * The content function will return the user login count number.
   */
  public function content() {
    return $this->customLogin->content();
  }

  /**
   * The currentUserPage function will return the user login count message.
   */
  public function currentUserPage() {
    $this->customLogin->currentUserPage();
  }

  /**
   * The allUserCounts will return the table of user login count and user name.
   */
  public function allUserCounts() {
    $this->customLogin->allUserCounts();
  }

}
