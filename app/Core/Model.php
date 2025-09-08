<?php

namespace App\Core;

use PDO;

class Model
{
    protected static string $table;
    protected static string $primaryKey = 'id';

    protected array $attributes = [];
    protected array $original = [];

    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
        $this->original = $this->attributes;
    }

    public function fill(array $attributes): static
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }
        return $this;
    }

    public function __get(string $key): mixed
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set(string $key, mixed $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function save(): bool
    {
        $db = Database::getInstance();

        if (isset($this->attributes[static::$primaryKey])) {
            $columns = [];
            $values = [];
            foreach ($this->attributes as $key => $value) {
                if ($key === static::$primaryKey) continue;
                $columns[] = "$key = ?";
                $values[] = $value;
            }
            $values[] = $this->attributes[static::$primaryKey];

            $sql = "UPDATE " . static::$table . " SET " . implode(", ", $columns)
                . " WHERE " . static::$primaryKey . " = ?";
            return $db->prepare($sql)->execute($values);
        } else {
            $columns = array_keys($this->attributes);
            $placeholders = implode(",", array_fill(0, count($columns), "?"));

            $sql = "INSERT INTO " . static::$table
                . " (" . implode(",", $columns) . ") VALUES (" . $placeholders . ")";
            $stmt = $db->prepare($sql);
            $result = $stmt->execute(array_values($this->attributes));

            if ($result) {
                $this->attributes[static::$primaryKey] = (int)$db->lastInsertId();
            }

            return $result;
        }
    }

    public function delete(): bool
    {
        if (!isset($this->attributes[static::$primaryKey])) {
            return false;
        }

        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM " . static::$table . " WHERE " . static::$primaryKey . " = ?");
        return $stmt->execute([$this->attributes[static::$primaryKey]]);
    }

    /**
     * @return array<int, static>
     */
    public static function all(): array
    {
        $stmt = Database::getInstance()->query("SELECT * FROM " . static::$table);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($row) => new static($row), $rows);
    }

    /**
     * @param int $id
     * @return static|null
     */
    public static function find(int $id): ?static
    {
        $stmt = Database::getInstance()->prepare(
            "SELECT * FROM " . static::$table . " WHERE " . static::$primaryKey . " = ? LIMIT 1"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? new static($row) : null;
    }
}