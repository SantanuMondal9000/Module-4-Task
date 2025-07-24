<?php

namespace Drupal\hook_example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
use Drupal\Core\Cache\Cache;

/**
 * Provides route controller methods for displaying user login counts.
 */
class LoginCountController extends ControllerBase {

  /**
   * Displays the login count for a specific user.
   *
   * @param \Drupal\user\Entity\User $user
   *   The user entity whose login count will be displayed.
   *
   * @return array
   *   A render array displaying the login count.
   */
  public function content(User $user) {
    $count = $user->get('field_login_count')->value ?? 0;

    return [
      '#markup' => $this->t('User @name has logged in @count times.', [
        '@name' => $user->getDisplayName(),
        '@count' => $count,
      ]),
    ];
  }

  /**
   * Displays the login count for the currently logged-in user.
   *
   * @return array
   *   A render array showing the login count or a message for anonymous users.
   */
  public function currentUserPage() {
    $current_user = $this->currentUser();

    if ($current_user->isAnonymous()) {
      return ['#markup' => $this->t('Please log in to see your login count.')];
    } 

    $user = User::load($current_user->id());
    $count = $user->get('field_login_count')->value ?? 0; 

    return [
      '#markup' => $this->t('You have logged in @count times.', ['@count' => $count]),
    ];
  }

  /**
   * Displays a table of login counts for all active users.
   *
   * @return array
   *   A render array containing a table of user IDs, usernames, and login counts.
   */
  public function allUserCounts() {
    $uid = $this->currentUser->id();
    $header = [
      $this->t('User ID'),
      $this->t('Username'),
      $this->t('Login Count'),
    ];

    $rows = [];

    // Load all active user IDs.
    $uids = \Drupal::entityQuery('user')
      ->accessCheck(FALSE)
      ->condition('status', 1)
      ->execute();

    $users = User::loadMultiple($uids);
    
    foreach ($users as $user) {
      $rows[] = [
        $user->id(),
        $user->getDisplayName(),
        $user->get('field_login_count')->value ?? 0,
      ];
    }

    return [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t('No users found.'),
      '#cache' => [
        'contexts' => ['user'],
        'tags' => ['user:' . $uid],
        'max-age' => Cache::PERMANENT,
      ], 
    ];
  }
}
