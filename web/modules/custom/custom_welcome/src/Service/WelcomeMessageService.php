<?php

namespace Drupal\custom_welcome\Service;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Cache\Cache;

class WelcomeMessageService {

  use StringTranslationTrait;

  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructs the WelcomeMessageService.
   */
  public function __construct(AccountProxyInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * Get the welcome message markup.
   *
   * @return array
   *   A renderable array.
   */
  public function getWelcomeMessage() {
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
