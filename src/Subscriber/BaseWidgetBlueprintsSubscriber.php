<?php

namespace DashboardPlugin\Subscriber;

use Karambol\KarambolApp;
use Karambol\VirtualSet\ItemCountEvent;
use Karambol\VirtualSet\ItemSearchEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DashboardPlugin\Widget\WidgetBlueprint;

class BaseWidgetBlueprintsSubscriber implements EventSubscriberInterface {

  use \Karambol\Util\AppAwareTrait;

  public static function getSubscribedEvents() {
    return [
      ItemSearchEvent::NAME => 'onSearchItems',
      ItemCountEvent::NAME => 'onCountItems'
    ];
  }

  public function onSearchItems(ItemSearchEvent $event) {
    $event->addItems($this->getBlueprints());
  }

  public function onCountItems(ItemCountEvent $event) {
    $event->add(count($this->getBlueprints()));
  }

  protected function getBlueprints() {

    $urlGen = $this->app['url_generator'];
    $translator = $this->app['translator'];
    $blueprints = [];

    $feedBlueprint = new WidgetBlueprint();
    $feedBlueprint
      ->setName('feed')
      ->setDescription($translator->trans('plugins.dashboard.admin.widget_blueprints.widgets.feed.description'))
      ->setUrl($urlGen->generate('plugin_dashboard_widget_feed'))
    ;
    $blueprints[] = $feedBlueprint;

    return $blueprints;

  }

}
