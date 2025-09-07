<?php

namespace App\Core;

use PDO;

class Model
{
    protected static string $table;

    public static function all(): array
    {
        $stmt = Database::getInstance()->query("SELECT * FROM " . static::$table);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::getInstance()->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }
}