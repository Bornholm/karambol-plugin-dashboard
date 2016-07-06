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
          ['label' => 'Tender', 'columnOffset' => null, 'columnWidth' => 6, 'order' => 0, 'url' => 'http://tender.cadoles.com/tender/', 'height' => 600 ],
          ['label' => 'Feed Widget', 'columnOffset' => null, 'columnWidth' => 6, 'order' => 0, 'url' => '/widgets/feed', 'height' => 600, 'options' => ['feedUrl' => 'https://linuxfr.org/news.atom'] ]
        ]
      ]
    ]);
  }

}
