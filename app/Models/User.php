<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

/**
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property int $birth_year
 * @property string $gender
 * @property string $photo
 * @property bool $is_admin
 * @property int $created_by
 * @property string $created_at
 */
class User extends Model
{
    protected static string $table = 'users';

    public static function create(array $data): int
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("
            INSERT INTO users (full_name, email, password, birth_year, gender, photo, is_admin, created_by, created_at)
            VALUES (:full_name, :email, :password, :birth_year, :gender, :photo, :is_admin, :created_by, NOW())
        ");

        $stmt->execute([
            ':full_name' => $data['full_name'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':birth_year' => $data['birth_year'],
            ':gender' => $data['gender'],
            ':photo' => $data['photo'],
            ':is_admin' => $data['is_admin'],
            ':created_by' => $data['created_by'],
        ]);

        return (int)$pdo->lastInsertId();
    }

    public static function findByEmail(string $email): ?self
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;

        return $data ? new self($data) : null;
    }
}