<?php

namespace DashboardPlugin\Subscriber;

use Karambol\KarambolApp;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DashboardPlugin\Widget\Widget;
use Karambol\VirtualSet\ItemCountEvent;
use Karambol\VirtualSet\ItemSearchEvent;

class DashboardAddWidgetSubscriber implements EventSubscriberInterface {

  protected $app;
  protected $blueprintName;
  protected $widgetOptions;

  public function __construct($app, $blueprintName, $widgetOptions) {
    $this->app = $app;
    $this->blueprintName = $blueprintName;
    $this->widgetOptions = $widgetOptions;
  }

  public static function getSubscribedEvents() {
    return [
      ItemSearchEvent::NAME => 'onSearchItems',
      ItemCountEvent::NAME => 'onCountItems'
    ];
  }

  public function onSearchItems(ItemSearchEvent $event) {

    $blueprint = $this->getWidgetBlueprint($this->blueprintName);

    if(!$blueprint) {
      $app['logger']->warn(sprintf('Couldn\'t find the widget blueprint "%s" !', $blueprintName));
      return;
    }

    $widget = new Widget();
    $widget->setLabel($this->getWidgetOpt('label', $blueprint->getName()));
    $widget->setUrl($blueprint->getUrl());
    $widget->setColumnWidth($this->getWidgetOpt('columnWidth', 12));
    $widget->setRow($this->getWidgetOpt('row', 0));
    $widget->setHeight($this->getWidgetOpt('height', null));
    $widget->setOrder($this->getWidgetOpt('order', null));
    $widget->setOptions($this->getWidgetOpt('options', []));

    $event->addItem($widget);

  }

  public function onCountItems(ItemCountEvent $event) {
    $blueprint = $this->getWidgetBlueprint($this->blueprintName);
    if($blueprint) $event->add(1);
  }

  protected function getWidgetBlueprint($blueprintName) {
    return $this->app['dashboard']->getBlueprints()->findOne(['name' => $blueprintName]);
  }

  protected function getWidgetOpt($optName, $defaultValue) {
    return isset($this->widgetOptions[$optName]) ? $this->widgetOptions[$optName] : $defaultValue;
  }

}
