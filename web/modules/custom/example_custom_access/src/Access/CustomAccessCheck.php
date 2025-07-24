<?php

namespace Drupal\example_custom_access\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;

/**
 * Custom access check class.
 */
class CustomAccessCheck {

  /**
   * Access logic: allow only users with editor role.
   * 
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The currently logged-in user's account object.
   */
  public function access(AccountInterface $account) {
    return in_array('editor', $account->getRoles())
      ? AccessResult::allowed()
      : AccessResult::forbidden();
  }
}
