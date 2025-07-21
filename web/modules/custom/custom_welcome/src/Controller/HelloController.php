<?php

namespace Drupal\custom_welcome\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Cache\Cache;

/**
 * This class will is custom controller that will show the hello message with the name of the current user login.
 */
class HelloController extends ControllerBase {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructor will initilize the AccountProxyInterface by depenedency injection.
   * 
   * @param Drupal\Core\Session\AccountProxyInterface $current_user
   */
  public function __construct(AccountProxyInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user')
    );
  }

  /**
   * This hello function will display the welcome message in the page.
   */
  public function hello() {
    $uid = $this->currentUser->id();
    $name = $this->currentUser->getDisplayName();

    return [
      '#markup' => $this->t('Hello @name!', ['@name' => $name]),
      '#cache' => [
        'tags' => ['user:' . $uid],
      ],
    ];
  }
}
