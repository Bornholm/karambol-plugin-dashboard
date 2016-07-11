<?php

namespace DashboardPlugin\Subscriber;

use Karambol\KarambolApp;
use Karambol\VirtualSet\ItemCountEvent;
use Karambol\VirtualSet\ItemSearchEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Karambol\Menu as Menu;

class DashboardAdminMenuSubscriber implements EventSubscriberInterface {

  use \Karambol\Util\AppAwareTrait;

  public static function getSubscribedEvents() {
    return [
      ItemSearchEvent::NAME => 'onSearchItems',
      ItemCountEvent::NAME => 'onCountItems'
    ];
  }

  public function onSearchItems(ItemSearchEvent $event) {

    $menuItems = $event->getItems();

    foreach($menuItems as $item) {
      if($item->getName() === Menu\MenuItems::ADMIN_PLUGINS) {
        $urlGen = $this->app['url_generator'];
        $widgetsItem = new Menu\MenuItem('plugins.dashboard.widget_blueprints', $urlGen->generate('admin_plugins_dashboard_widget_blueprints_list'), [
          'icon_class' => 'fa fa-puzzle-piece'
        ]);
        $item->addItem($widgetsItem);
      }
    }

  }

  public function onCountItems(ItemCountEvent $event) {
    $event->add(1);
  }

}
