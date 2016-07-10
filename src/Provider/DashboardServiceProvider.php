<?php

namespace DashboardPlugin\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;
use DashboardPlugin\Service\DashboardService;

class DashboardServiceProvider implements ServiceProviderInterface
{

  public function register(Application $app) {
    $app['dashboard'] = new DashboardService();
  }

  public function boot(Application $app) {}

}
