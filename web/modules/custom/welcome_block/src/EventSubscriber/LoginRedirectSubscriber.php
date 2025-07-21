<?php

namespace Drupal\welcome_block\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Path\CurrentPathStack;
use Drupal\Core\Routing\TrustedRedirectResponse;

/**
 * Redirect users to the custom destination url after login..
 */
class LoginRedirectSubscriber implements EventSubscriberInterface {

  /**
   * The current user object. Provides access to the currently logged-in user's information.
   * 
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * The current path service.Used to retrieve the current URL path.
   *
   * @var \Drupal\Core\Path\CurrentPathStack
   */
  protected $currentPath;

  /**
   * Constructs a new instance of the class.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user service.
   * @param \Drupal\Core\Path\CurrentPathStack $current_path
   *   The current path stack service.
   */
  public function __construct(AccountProxyInterface $current_user, CurrentPathStack $current_path) {
    $this->currentUser = $current_user;
    $this->currentPath = $current_path;
  }

  /**
   * {@inheritdoc}
   */
  public function onKernelRequest(RequestEvent $event) {
    if (!$event->isMainRequest()) {
      return;
    }

    $path = parse_url($this->currentPath->getPath(), PHP_URL_PATH);

    if (preg_match('#^/user(/\d+)?$#', $path) && $this->currentUser->isAuthenticated()) {
      $session = \Drupal::request()->getSession();

      if ($session->has('custom_login_redirect')) {
        $url = $session->get('custom_login_redirect');
        $session->remove('custom_login_redirect');
        $event->setResponse(new TrustedRedirectResponse($url));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::REQUEST => ['onKernelRequest'],
    ];
  }
}
