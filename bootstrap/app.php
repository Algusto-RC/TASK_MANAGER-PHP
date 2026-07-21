<?php

declare(strict_types=1);

use App\Config\Env;

$basePath = dirname(__DIR__);
$autoloadPath = $basePath . '/vendor/autoload.php';

if (!is_file($autoloadPath)) {
    throw new RuntimeException(
        'Autoload do Composer não encontrado. Execute "composer install" na raiz do projeto.'
    );
}

require_once $autoloadPath;

Env::load($basePath . '/.env');

date_default_timezone_set((string) Env::get('APP_TIMEZONE', 'America/Sao_Paulo'));

$debug = Env::bool('APP_DEBUG', false);
error_reporting($debug ? E_ALL : 0);
ini_set('display_errors', $debug ? '1' : '0');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'secure' => Env::bool('SESSION_SECURE_COOKIE', false),
        'samesite' => 'Lax',
        'path' => '/',
    ]);

    session_start();
}

return [
    'name' => (string) Env::get('APP_NAME', 'Task Manager PHP'),
    'environment' => (string) Env::get('APP_ENV', 'production'),
    'debug' => $debug,
    'base_path' => $basePath,
];
