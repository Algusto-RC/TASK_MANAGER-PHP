<?php

declare(strict_types=1);

use App\Database\Connection;

require dirname(__DIR__) . '/bootstrap/app.php';

if (PHP_SAPI !== 'cli') {
    fwrite(STDERR, "Este script deve ser executado pelo terminal.\n");
    exit(1);
}

try {
    $pdo = Connection::get();
    $result = $pdo->query('SELECT 1 AS connection_ok')->fetch();

    if (($result['connection_ok'] ?? null) !== 1) {
        throw new RuntimeException('O banco respondeu com um resultado inesperado.');
    }

    fwrite(STDOUT, "Conexão com o banco estabelecida com sucesso.\n");
    exit(0);
} catch (Throwable $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
}
