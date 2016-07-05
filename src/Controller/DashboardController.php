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
    return $twig->render('dashboard/index.html.twig', [
      'widgets' => [
        [
          ['label' => 'Test', 'columnOffset' => null, 'columnWidth' => 4, 'order' => 0, 'url' => '/widgets/rss', 'height' => 600 ],
          ['label' => 'Test', 'columnOffset' => null, 'columnWidth' => 4, 'order' => 0, 'url' => '/widgets/rss', 'height' => 800 ]
        ]
      ]
    ]);
  }

}
