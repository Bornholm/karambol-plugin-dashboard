<?php

namespace DashboardPlugin\Controller;

use Karambol\Controller\Controller;
use Karambol\KarambolApp;

class DashboardController extends Controller {

  public function mount(KarambolApp $app) {
    $app->get('/dashboard', [$this, 'showDashboard'])->bind('dashboard');
  }

  public function showDashboard() {

    $twig = $this->get('twig');
    $widgets = $this->get('dashboard')->getWidgets();

    return $twig->render('plugins/dashboard/dashboard/index.html.twig', [
      'widgets' => $widgets
    ]);

  }

}
