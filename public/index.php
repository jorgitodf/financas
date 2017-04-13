<?php

use Psr\Http\Message\ServerRequestInterface;
use Financas\Application;
use Financas\Plugins\RoutePlugin;
use Financas\Plugins\ViewPlugin;
use Financas\ServiceContainer;
use Financas\Plugins\DbPlugin;

require_once __DIR__ . '/../vendor/autoload.php';

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());
$app->plugin(new DbPlugin());


$app->get('/home/{name}/{id}', function(ServerRequestInterface $request) {
    $response = new \Zend\Diactoros\Response();
    $response->getBody()->write("response com emmiter do diactoros");
    return $response;
});


$app
    ->get('/category-costs', function () use ($app) {
        $view = $app->service('view.renderer');
        $meuModel = new \Financas\Models\CategoryCost();
        $categories = $meuModel->all();
        return $view->render('category-costs/list.html.twig',  [
            'categories' => $categories
        ]);
    }, 'category-costs.list')
    ->get('/category-costs/new', function () use ($app) {
        $view = $app->service('view.renderer');
        return $view->render('category-costs/create.html.twig');
    }, 'category-costs.new')
    ->post('/category-costs/store', function (ServerRequestInterface $request) use($app) {
        //Cadastro de Category
        $data = $request->getParsedBody();
        \Financas\Models\CategoryCost::create($data);
        return $app->route('category-costs.list');
    }, 'category-costs.store')
    ->get('/category-costs/edit/{id}', function (ServerRequestInterface $request) use($app) {
        $view = $app->service('view.renderer');
        $id = $request->getAttribute('id');
        $category = \Financas\Models\CategoryCost::findOrFail($id);
        return $view->render('category-costs/edit.html.twig', [
            'category' => $category
        ]);
    }, 'category-costs.edit')
    ->post('/category-costs/update/{id}', function (ServerRequestInterface $request) use($app) {
        $id = $request->getAttribute('id');
        $category = \Financas\Models\CategoryCost::find($id);
        $data = $request->getParsedBody();
        //$category->name = $data['name'];
        $category->fill($data);
        $category->save();
        return $app->route('category-costs.list');
    }, 'category-costs.update')
    ->get('/category-costs/show/{id}', function (ServerRequestInterface $request) use($app) {
        $view = $app->service('view.renderer');
        $id = $request->getAttribute('id');
        $category = \Financas\Models\CategoryCost::findOrFail($id);
        return $view->render('category-costs/show.html.twig', [
            'category' => $category
        ]);
    }, 'category-costs.show')
    ->get('/category-costs/delete/{id}', function (ServerRequestInterface $request) use($app) {
        $id = $request->getAttribute('id');
        $category = \Financas\Models\CategoryCost::findOrFail($id);
        $category->delete();
        return $app->route('category-costs.list');
    }, 'category-costs.delete');

$app->start();