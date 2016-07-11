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

    $feed1 = new Widget();
    $feed1->setLabel('feed1');
    $feed1->setUrl('/widgets/feed');
    $feed1->setColumnWidth(6);
    $feed1->setOptions(['feedUrl' => 'https://linuxfr.org/news.atom']);

    $feed2 = new Widget();
    $feed2->setLabel('feed2');
    $feed2->setUrl('/widgets/feed');
    $feed2->setColumnWidth(6);
    $feed2->setOrder(2);
    $feed2->setHeight(500);
    $feed2->setOptions(['feedUrl' => 'http://korben.info/feed']);


    $widgets = [$feed2, $feed1];//$this->get('dashboard')->getWidgets();

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
