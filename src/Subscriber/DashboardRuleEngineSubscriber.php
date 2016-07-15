<?php

namespace DashboardPlugin\Subscriber;

use Karambol\KarambolApp;
use Karambol\RuleEngine\RuleEngineEvent;
use Karambol\RuleEngine\RuleEngineService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DashboardPlugin\Subscriber\DashboardAddWidgetSubscriber;

class DashboardRuleEngineSubscriber implements EventSubscriberInterface {

  use \Karambol\Util\AppAwareTrait;

  public static function getSubscribedEvents() {
    return [
      RuleEngineEvent::BEFORE_EXECUTE_RULES => 'onBeforeExecuteRules'
    ];
  }

  public function onBeforeExecuteRules(RuleEngineEvent $event) {

    if($event->getType() !== RuleEngineService::CUSTOMIZATION) return;

    $app = $this->app;
    $provider = $event->getFunctionProvider();

    $provider->registerFunction(
      'addWidgetToDashboard',
      function($vars, $widgetName, $widgetOptions) use ($app) {
        $app['dashboard']->getWidgets()->addSubscriber(new DashboardAddWidgetSubscriber($app, $widgetName, $widgetOptions));
      }
    );

  }

}
