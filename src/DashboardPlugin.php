<?php

namespace DashboardPlugin;

use Karambol\Plugin\PluginInterface;
use Karambol\KarambolApp;
use DashboardPlugin\Controller\DashboardController;
use DashboardPlugin\Controller\Widget as WidgetController;

class DashboardPlugin implements PluginInterface
{

  public function boot(KarambolApp $app, array $options) {
    $this->addPluginPages($app);
    $this->addPluginViews($app);
    $this->addPluginTranslation($app);
    $this->addControllers($app);
    $this->addTwigHelpers($app);
  }

  public function addPluginTranslation(KarambolApp $app) {
    $app['translator'] = $app->share($app->extend('translator', function($translator) {
      $translator->addResource('yaml', __DIR__.'/locales/fr.yml', 'fr');
      return $translator;
    }));
  }

  public function addPluginPages(KarambolApp $app) {
    $app['pages']->addSubscriber(new DashboardPagesSubscriber($app));
  }

  public function addControllers(KarambolApp $app) {
    $dashboardCtrl = new DashboardController();
    $dashboardCtrl->bindTo($app);
    $rssWidgetCtrl = new WidgetController\FeedWidgetController();
    $rssWidgetCtrl->bindTo($app);
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
