<?php

declare(strict_types=1);

namespace App\Database;

use App\Config\Env;
use PDO;
use PDOException;
use RuntimeException;

final class Connection
{
    private static ?PDO $instance = null;

    private function __construct()
    {
    }

    public static function get(): PDO
    {
        if (self::$instance instanceof PDO) {
            return self::$instance;
        }

        $host = (string) Env::get('DB_HOST', '127.0.0.1');
        $port = (string) Env::get('DB_PORT', '3306');
        $database = trim((string) Env::get('DB_NAME', ''));
        $username = trim((string) Env::get('DB_USER', ''));
        $password = (string) Env::get('DB_PASSWORD', '');

        if ($database === '' || $username === '') {
            throw new RuntimeException('DB_NAME e DB_USER devem estar configurados no arquivo .env.');
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
            $host,
            $port,
            $database
        );

        try {
            self::$instance = new PDO(
                $dsn,
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $exception) {
            throw new RuntimeException(
                'Não foi possível estabelecer conexão com o banco de dados.',
                0,
                $exception
            );
        }

        return self::$instance;
    }
}
