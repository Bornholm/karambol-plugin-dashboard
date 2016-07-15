<?php

namespace DashboardPlugin;

use Karambol\Plugin\PluginInterface;
use Karambol\KarambolApp;
use Karambol\Menu as Menu;
use Karambol\Menu\Menus;
use DashboardPlugin\Provider\DashboardServiceProvider;
use DashboardPlugin\Subscriber as Subscriber;

class DashboardPlugin implements PluginInterface
{

  public function boot(KarambolApp $app, array $options) {
    $this->addEntities($app);
    $this->addServices($app);
    $this->addSubscribers($app);
    $this->addPluginViews($app);
    $this->addPluginTranslation($app);
    $this->addControllers($app);
    $this->addTwigHelpers($app);
  }

  public function addPluginTranslation(KarambolApp $app) {
    $app['translator'] = $app->share($app->extend('translator', function($translator) {
      $translator->addResource('yaml', __DIR__.'/../locales/fr.yml', 'fr');
      return $translator;
    }));
  }

  public function addEntities(KarambolApp $app) {
    $annotationDriver = $app['orm']->getConfiguration()->getMetadataDriverImpl();
    $annotationDriver->addPaths([__DIR__.'/Entity']);
  }

  public function addServices(KarambolApp $app) {
    $app->register(new DashboardServiceProvider());
  }

  public function addSubscribers(KarambolApp $app) {
    $app['menus']->getMenu(Menus::ADMIN_MAIN)->addSubscriber(new Subscriber\DashboardAdminMenuSubscriber($app));
    $app['pages']->addSubscriber(new Subscriber\DashboardPagesSubscriber($app));
    $app['dashboard']->getBlueprints()->addSubscriber(new Subscriber\BaseWidgetBlueprintsSubscriber($app));
    $app['dashboard']->getBlueprints()->addSubscriber(new Subscriber\CustomWidgetBlueprintsSubscriber($app));
    $app['rule_engine']->addSubscriber(new Subscriber\DashboardRuleEngineSubscriber($app));
  }

  public function addControllers(KarambolApp $app) {
    $controllers = [
      'DashboardPlugin\Controller\DashboardController',
      'DashboardPlugin\Controller\Widget\FeedWidgetController',
      'DashboardPlugin\Controller\Admin\WidgetBlueprintsController'
    ];
    foreach($controllers as $controllerClass) {
      $controller = new $controllerClass();
      $controller->bindTo($app);
    }
  }

  public function addPluginViews($app) {
    $twigPaths = $app['twig.path'];
    array_unshift($twigPaths, __DIR__.'/Views');
    $app['twig.path'] = $twigPaths;
  }

  public function addTwigHelpers($app) {
    $app['twig'] = $app->share($app->extend('twig', function($twig) {
      $twig->addFilter(new \Twig_SimpleFilter('b64_encode', 'base64_encode'));
      $twig->addFilter(new \Twig_SimpleFilter('b64_decode', 'base64_decode'));
      return $twig;
    }));
  }

}
