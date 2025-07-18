<?php
namespace Drupal\hook_example\Service;

use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\Cache\Cache;
use Drupal\user\Entity\User;

class CustomLoginService {
  

  use StringTranslationTrait;
  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  public function __construct(AccountProxyInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * The displayLoginCount() will dislpay the user name and the login count.
   * 
   * @return array
   */
  public function displayLoginCount(){
    $user = User::load($this->currentUser->id());
    $count = $user->get('field_login_count')->value ?? 0;

    return[
      '#markup' => $this->t('User @name has logged in @count times.',[
        '@name' => $user->getDisplayName(),
        '@count' =>$count,
      ]),
    ];
  }

  /**
   * The currentUserPage() will dislplay the logged user count number.
   * 
   * @return array
   */
  public function currentUserPage(){
    if ($this->currentUser->isAnonymous()) {
      return ['#markup' => $this->t('Please log in to see your login count.')];
    } 

    $user = User::load($this->currentUser->id());
    $count = $user->get('field_login_count')->value ?? 0; 

    return [
      '#markup' => $this->t('You have logged in @count times.', ['@count' => $count]),
    ];
  }

  /**
   * The allUserCounts() will display a table with user name and login count.
   * 
   * @return array
   * A render array containing a table of users and their login counts.
   */
  public function allUserCounts() {
    $header = [
      $this->t('User ID'),
      $this->t('Username'),
      $this->t('Login Count'),
    ];

    $rows = [];

    // Load all users
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
        'tags' => ['user:' . $this->currentUser->id()],
        'max-age' => Cache::PERMANENT,
      ],
    ];
  }
}
?>
