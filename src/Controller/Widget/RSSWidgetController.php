<?php

namespace DashboardPlugin\Controller\Widget;

use Karambol\Controller\Controller;
use Karambol\KarambolApp;
use PicoFeed\Reader\Reader;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

class RSSWidgetController extends Controller {

  public function mount(KarambolApp $app) {
    $app->get('/widgets/rss', [$this, 'showRSSWidget'])->bind('widget_rss');
    $app->get('/widgets/rss/feed', [$this, 'fetchFeed'])->bind('widget_rss_feed');
  }

  public function showRSSWidget() {
    $twig = $this->get('twig');
    return $twig->render('widgets/rss/index.html.twig');
  }

  public function fetchFeed() {

    $request = $this->get('request');
    $feedUrl = $request->query->get('u');

    if(empty($feedUrl)) throw new BadRequestHttpException();

    $reader = new Reader();
    $resource = $reader->download($feedUrl);

    $parser = $reader->getParser(
        $resource->getUrl(),
        $resource->getContent(),
        $resource->getEncoding()
    );

    $feed = $parser->execute();

    return new JsonResponse($feed);

  }



}
