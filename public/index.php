<?php

use Psr\Http\Message\ServerRequestInterface;
use Financas\Application;
use Financas\Plugins\RoutePlugin;
use Financas\Plugins\ViewPlugin;
use Financas\ServiceContainer;

require_once __DIR__ . '/../vendor/autoload.php';

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());


$app->get('/{name}', function(ServerRequestInterface $request) use($app) {
    $view = $app->service('view.renderer');
    return $view->render('test.html.twig', ['name' => $request->getAttribute('name')]);
});

$app->get('/home/{name}/{id}', function(ServerRequestInterface $request) {
    $response = new \Zend\Diactoros\Response();
    $response->getBody()->write("response com emmiter do diactoros");
    return $response;
});

$app->start();
