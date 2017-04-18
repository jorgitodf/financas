<?php
use Financas\Application;
use Financas\Plugins\AuthPlugin;
use Financas\Plugins\DbPlugin;
use Financas\ServiceContainer;

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);
$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());
return $app;