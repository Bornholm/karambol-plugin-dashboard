<?php

namespace DashboardPlugin;

use Karambol\KarambolApp;
use Karambol\VirtualSet\ItemCountEvent;
use Karambol\VirtualSet\ItemSearchEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Karambol\Menu\MenuItem;

class DashboardMenuSubscriber implements EventSubscriberInterface {

  public static function getSubscribedEvents() {
    return [
      ItemSearchEvent::NAME => 'onSearchItems',
      ItemCountEvent::NAME => 'onCountItems'
    ];
  }

  public function onSearchItems(ItemSearchEvent $event) {
    dump($event);
  }

  public function onCountItems(ItemCountEvent $event) {
    $event->add(1);
  }

}
