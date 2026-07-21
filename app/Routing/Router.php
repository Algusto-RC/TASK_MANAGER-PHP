<?php

declare(strict_types=1);

namespace App\Routing;

use RuntimeException;

final class Router
{
    /**
     * @var list<array{
     *     method: string,
     *     path: string,
     *     pattern: string,
     *     handler: callable
     * }>
     */
    private array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->add('GET', $path, $handler);
    }

    public function post(string $path, callable $handler): void
    {
        $this->add('POST', $path, $handler);
    }

    public function dispatch(string $method, string $uri): string
    {
        $method = strtoupper($method);
        $path = $this->extractPath($uri);
        $allowedMethods = [];

        foreach ($this->routes as $route) {
            $matches = [];

            if (preg_match($route['pattern'], $path, $matches) !== 1) {
                continue;
            }

            if ($route['method'] !== $method) {
                $allowedMethods[] = $route['method'];

                continue;
            }

            $parameters = array_filter(
                $matches,
                static fn (string|int $key): bool => is_string($key),
                ARRAY_FILTER_USE_KEY
            );

            $response = call_user_func_array(
                $route['handler'],
                array_values($parameters)
            );

            if (!is_string($response)) {
                throw new RuntimeException(
                    'O manipulador da rota deve retornar uma string.'
                );
            }

            return $response;
        }

        if ($allowedMethods !== []) {
            $allowedMethods = array_values(
                array_unique($allowedMethods)
            );

            sort($allowedMethods);

            http_response_code(405);
            header('Allow: ' . implode(', ', $allowedMethods));

            return $this->errorPage(
                405,
                'Método não permitido.'
            );
        }

        http_response_code(404);

        return $this->errorPage(
            404,
            'Página não encontrada.'
        );
    }

    private function add(
        string $method,
        string $path,
        callable $handler
    ): void {
        $normalizedPath = $this->normalizePath($path);

        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $normalizedPath,
            'pattern' => $this->compilePattern($normalizedPath),
            'handler' => $handler,
        ];
    }

    private function extractPath(string $uri): string
    {
        $path = parse_url($uri, PHP_URL_PATH);

        return $this->normalizePath(
            is_string($path) ? rawurldecode($path) : '/'
        );
    }

    private function normalizePath(string $path): string
    {
        $normalizedPath = '/' . trim($path, '/');

        return $normalizedPath === '/'
            ? '/'
            : $normalizedPath;
    }

    private function compilePattern(string $path): string
    {
        if ($path === '/') {
            return '#^/$#';
        }

        $segments = explode('/', trim($path, '/'));
        $compiledSegments = [];

        foreach ($segments as $segment) {
            if (
                preg_match(
                    '/^\{([A-Za-z_][A-Za-z0-9_]*)\}$/',
                    $segment,
                    $matches
                ) === 1
            ) {
                $compiledSegments[] = sprintf(
                    '(?P<%s>[^/]+)',
                    $matches[1]
                );

                continue;
            }

            $compiledSegments[] = preg_quote(
                $segment,
                '#'
            );
        }

        return '#^/'
            . implode('/', $compiledSegments)
            . '$#';
    }

    private function errorPage(
        int $status,
        string $message
    ): string {
        return sprintf(
            '<!DOCTYPE html>'
            . '<html lang="pt-BR">'
            . '<head><meta charset="UTF-8">'
            . '<meta name="viewport" '
            . 'content="width=device-width, initial-scale=1.0">'
            . '<title>%d</title></head>'
            . '<body><main><h1>%d</h1><p>%s</p></main></body>'
            . '</html>',
            $status,
            $status,
            htmlspecialchars(
                $message,
                ENT_QUOTES,
                'UTF-8'
            )
        );
    }
}