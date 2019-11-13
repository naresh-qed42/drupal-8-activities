<?php

namespace Drupal\activities_d8\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * A Staticpage controller.
 */
class DynamicRouteController extends ControllerBase {

  /**
   * Page callback function.
   *
   * @param string $arg
   *   Get an argument from url and display it on page.
   */
  public function dynamic_content($arg) {
    $output = [
      '#markup' => 'Hello! I am your ' . $arg . ' listing page.',
    ];
    return $output;
  }

}
