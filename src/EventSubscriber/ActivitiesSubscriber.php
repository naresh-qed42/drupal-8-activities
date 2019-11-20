<?php

namespace Drupal\activities_d8\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Drupal\activities_d8\Event\NodeInsertDemoEvent;

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
      NodeInsertDemoEvent::DEMO_NODE_INSERT => 'onDemoNodeInsert',
    ];
  }

  /**
   *
   */
  public function onDemoNodeInsert(NodeInsertDemoEvent $event) {
    $entity = $event->getEntity();
    \Drupal::logger('event_subscriber_demo')->notice('New @type: @title. Created by: @owner',
      [
        '@type' => $entity->getType(),
        '@title' => $entity->label(),
        '@owner' => $entity->getOwner()->getDisplayName(),
      ]);
  }

  /**
   *
   */
  public function onResponse(FilterResponseEvent $event) {
    $response = $event->getResponse();
    $response->headers->add(['access-control-allow-origin' => 'test']);
  }

}
