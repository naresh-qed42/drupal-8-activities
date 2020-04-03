<?php
namespace Drupal\activities_d8\Access;

use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;
use Drupal\node\NodeInterface;

/**
 * Checks access for displaying configuration translation page.
 * extra lines for cherry pick.
 */
class CustomAccessCheck implements AccessInterface {

  /**
   * A custom access check.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   Run access checks for this account.
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   *   The access result.
   */
  public function access(AccountInterface $account, nodeInterface $nid) {
    $nodeAuthor = $nid->getOwnerId();
    $currentUserId = $account->id();
    return AccessResult::allowedIf($nodeAuthor == $currentUserId);
  }

}
