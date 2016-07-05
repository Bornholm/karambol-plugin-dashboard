<?php

namespace DashboardPlugin;

use Karambol\KarambolApp;
use Karambol\VirtualSet\ItemCountEvent;
use Karambol\VirtualSet\ItemSearchEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Karambol\Page\Page;
use Karambol\Util\AppAwareTrait;

class DashboardPagesSubscriber implements EventSubscriberInterface {

  use AppAwareTrait;

  public static function getSubscribedEvents() {
    return [
      ItemSearchEvent::NAME => 'onSearchPages',
      ItemCountEvent::NAME => 'onCountPages'
    ];
  }

  public function onSearchPages(ItemSearchEvent $event) {
    $urlGen = $this->app['url_generator'];
    $translator = $this->app['translator'];
    $page = new Page(
      $translator->trans('pages.plugins.dashboard'),
      $urlGen->generate('dashboard'),
      'dashboard'
    );
    $event->addItem($page);
  }

  public function onCountPages(ItemCountEvent $event) {
    $event->add(1);
  }

}
