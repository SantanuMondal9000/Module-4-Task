<?php
namespace Drupal\custom_welcome\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Cache\Cache;

class HelloController extends ControllerBase {

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructor will initilize the AccountProxyInterface by depenedency injection.
   */
  public function __construct(AccountProxyInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * This is the container factory method to inject the current_user via Dependency injection in controller.
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
        'contexts' => ['user'],
        'tags' => ['user:' . $uid],
        'max-age' => Cache::PERMANENT,
      ],
    ];
  }
}

?>
