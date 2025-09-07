<?php

namespace App\Core;

use PDO;

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}
    public function __wakeup() {}

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                '%s:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                $_ENV['DB_CONNECTION'],
                $_ENV['DB_HOST'],
                $_ENV['DB_PORT'],
                $_ENV['DB_DATABASE'],
            );
            self::$instance = new PDO(
                $dsn,
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
        return self::$instance;
    }
}