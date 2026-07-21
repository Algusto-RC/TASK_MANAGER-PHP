<?php

declare(strict_types=1);

$uriPath = parse_url(
    (string) ($_SERVER['REQUEST_URI'] ?? '/'),
    PHP_URL_PATH
);

$uriPath = is_string($uriPath)
    ? rawurldecode($uriPath)
    : '/';

$publicDirectory = realpath(__DIR__);
$requestedFile = realpath(
    __DIR__ . $uriPath
);

if (
    $uriPath !== '/'
    && $publicDirectory !== false
    && $requestedFile !== false
    && str_starts_with(
        $requestedFile,
        $publicDirectory . DIRECTORY_SEPARATOR
    )
    && is_file($requestedFile)
) {
    return false;
}

require __DIR__ . '/index.php';