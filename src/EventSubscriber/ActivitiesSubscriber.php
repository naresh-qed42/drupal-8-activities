<?php

namespace Drupal\activities_d8\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 *
 */
class ActivitiesSubscriber implements EventSubscriberInterface {

  /**
   *
   */
  public static function getSubscribedEvents() {
    return [
      KernelEvents::RESPONSE => 'onResponse',
    ];
  }

  /**
   *
   */
  public function onResponse(FilterResponseEvent $event) {
    $response = $event->getResponse();
    $response->headers->add(['access-control-allow-origin' => 'test']);
  }

}
