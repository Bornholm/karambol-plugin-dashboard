<?php

namespace DashboardPlugin\Controller\Widget;

use Karambol\Controller\Controller;
use Karambol\KarambolApp;

class RSSWidgetController extends Controller {

  public function mount(KarambolApp $app) {
    $app->get('/widgets/rss', [$this, 'showRSSWidget'])->bind('widget_rss');
  }

  public function showRSSWidget() {
    $twig = $this->get('twig');
    return $twig->render('widgets/rss/index.html.twig');
  }

}
