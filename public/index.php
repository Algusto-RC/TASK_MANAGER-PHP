<?php

declare(strict_types=1);

use App\Routing\Router;

$app = require dirname(__DIR__)
    . '/bootstrap/app.php';

$router = require $app['base_path']
    . '/routes/web.php';

if (!$router instanceof Router) {
    throw new RuntimeException(
        'O arquivo routes/web.php deve retornar '
        . 'uma instância de Router.'
    );
}

header('Content-Type: text/html; charset=UTF-8');

$response = $router->dispatch(
    (string) ($_SERVER['REQUEST_METHOD'] ?? 'GET'),
    (string) ($_SERVER['REQUEST_URI'] ?? '/')
);

echo $response;