<?php

namespace DashboardPlugin\Controller;

use Karambol\Controller\Controller;
use Karambol\KarambolApp;
use DashboardPlugin\Widget\Widget;

class DashboardController extends Controller {

  public function mount(KarambolApp $app) {
    $app->get('/dashboard', [$this, 'showDashboard'])->bind('dashboard');
  }

  public function showDashboard() {

    $twig = $this->get('twig');
    $widgets = $this->get('dashboard')->getWidgets();

    $rows = [];
    foreach($widgets as $widget) {
      $rowIndex = $widget->getRow();
      if(!isset($rows[$rowIndex])) $rows[$rowIndex] = [];
      $rows[$rowIndex][] = $widget;
    }

    foreach($rows as &$row) {
      usort($row, function($w1, $w2) {
        if ($w1->getOrder() == $w2->getOrder()) {
          return 0;
        }
        return ($w1->getOrder() < $w2->getOrder()) ? -1 : 1;
      });
    }

    return $twig->render('plugins/dashboard/dashboard/index.html.twig', [
      'widgets' => $rows
    ]);

  }

}
