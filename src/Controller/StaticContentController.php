<?php

namespace Drupal\activities_d8\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * A Staticpage controller.
 */
class StaticContentController extends ControllerBase {

  /**
   * Page callback function.
   */
  public function static() {
    $output = [
      '#markup' => $this->t('Hello! This is static page.'),
    ];
    return $output;
  }

  /**
   *
   */
  public function access_training_content(AccountInterface $account) {
    return AccessResult::allowedIf($account->hasPermission('Access training content'));
  }

}
