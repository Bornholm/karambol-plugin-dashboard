<?php

namespace DashboardPlugin\Controller\Widget;

use Karambol\Controller\Controller;
use Karambol\KarambolApp;
use PicoFeed\Reader\Reader;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

class FeedWidgetController extends Controller {

  public function mount(KarambolApp $app) {
    $app->get('/widgets/feed', [$this, 'showFeedWidget'])->bind('widget_feed');
    $app->get('/widgets/feed/fetch', [$this, 'fetchFeed'])->bind('widget_feed_fetch');
  }

  public function showFeedWidget() {
    $twig = $this->get('twig');
    return $twig->render('widgets/feed/index.html.twig');
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
