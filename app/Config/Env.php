<?php

declare(strict_types=1);

namespace App\Config;

final class Env
{
    private static bool $loaded = false;

    private function __construct()
    {
    }

    public static function load(string $filePath): void
    {
        if (self::$loaded) {
            return;
        }

        if (!is_file($filePath) || !is_readable($filePath)) {
            self::$loaded = true;
            return;
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if ($lines === false) {
            throw new \RuntimeException('Não foi possível ler o arquivo de ambiente.');
        }

        foreach ($lines as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#')) {
                continue;
            }

            [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
            $key = trim($key);

            if ($key === '' || self::exists($key)) {
                continue;
            }

            $value = self::normalizeValue($value);

            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
            putenv(sprintf('%s=%s', $key, $value));
        }

        self::$loaded = true;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $value = getenv($key);

        if ($value !== false) {
            return $value;
        }

        return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
    }

    public static function bool(string $key, bool $default = false): bool
    {
        $value = self::get($key);

        if ($value === null) {
            return $default;
        }

        $normalized = filter_var($value, FILTER_VALIDATE_BOOL, FILTER_NULL_ON_FAILURE);

        return $normalized ?? $default;
    }

    private static function exists(string $key): bool
    {
        return getenv($key) !== false || isset($_ENV[$key]) || isset($_SERVER[$key]);
    }

    private static function normalizeValue(string $value): string
    {
        $value = trim($value);
        $length = strlen($value);

        if ($length >= 2) {
            $firstCharacter = $value[0];
            $lastCharacter = $value[$length - 1];

            if (($firstCharacter === '"' && $lastCharacter === '"')
                || ($firstCharacter === "'" && $lastCharacter === "'")) {
                return substr($value, 1, -1);
            }
        }

        return $value;
    }
}
