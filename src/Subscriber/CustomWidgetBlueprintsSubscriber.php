<?php

namespace DashboardPlugin\Subscriber;

use Karambol\KarambolApp;
use Karambol\VirtualSet\ItemCountEvent;
use Karambol\VirtualSet\ItemSearchEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DashboardPlugin\Widget\WidgetBlueprint;

class CustomWidgetBlueprintsSubscriber implements EventSubscriberInterface {

  use \Karambol\Util\AppAwareTrait;

  public static function getSubscribedEvents() {
    return [
      ItemSearchEvent::NAME => 'onSearchItems',
      ItemCountEvent::NAME => 'onCountItems'
    ];
  }

  public function onSearchItems(ItemSearchEvent $event) {
    $orm = $this->app['orm'];
    $blueprints = $orm->getRepository('DashboardPlugin\Entity\CustomWidgetBlueprint')->findAll($event->getCriteria());
    $event->addItems($blueprints);
  }

  public function onCountItems(ItemCountEvent $event) {
    $orm = $this->app['orm'];
    $count = $orm->getRepository('DashboardPlugin\Entity\CustomWidgetBlueprint')->count();
    $event->add($count);
  }

}
