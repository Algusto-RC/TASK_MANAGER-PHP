<?php

declare(strict_types=1);

$app = require dirname(__DIR__) . '/bootstrap/app.php';

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($app['name'], ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <main>
        <h1><?= htmlspecialchars($app['name'], ENT_QUOTES, 'UTF-8') ?></h1>
        <p>Estrutura base da aplicação carregada com sucesso.</p>
        <p>Ambiente: <?= htmlspecialchars($app['environment'], ENT_QUOTES, 'UTF-8') ?></p>
    </main>
</body>
</html>
