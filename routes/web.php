<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Routing\Router;
use App\View\View;

$router = new Router();

$view = new View(
    $app['base_path'] . '/resources/views'
);

$homeController = new HomeController(
    app: $app,
    view: $view
);

$router->get(
    '/',
    [$homeController, 'index']
);

return $router;