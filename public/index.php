<?php
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
    if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

use Psr\Http\Message\ServerRequestInterface;
use Financas\Application;
use Financas\Plugins\RoutePlugin;
use Financas\Plugins\ViewPlugin;
use Financas\ServiceContainer;
use Financas\Plugins\DbPlugin;
use Financas\Plugins\AuthPlugin;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/helpers.php';

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);



$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());
$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());

$app->get('/home/{name}/{id}', function(ServerRequestInterface $request) {
    $response = new \Zend\Diactoros\Response();
    $response->getBody()->write("response com emmiter do diactoros");
    return $response;
});

require_once __DIR__ . '/../src/controllers/charts.php';
require_once __DIR__ . '/../src/controllers/statements.php';
require_once __DIR__ . '/../src/controllers/category-costs.php';
require_once __DIR__ . '/../src/controllers/bill-receives.php';
require_once __DIR__ . '/../src/controllers/bill-pays.php';
require_once __DIR__ . '/../src/controllers/users.php';
require_once __DIR__ . '/../src/controllers/auth.php';

$app->start();