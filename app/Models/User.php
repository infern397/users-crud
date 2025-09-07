<?php

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

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
            ':full_name'  => $data['full_name'],
            ':email'      => $data['email'],
            ':password'   => $data['password'],
            ':birth_year' => $data['birth_year'],
            ':gender'     => $data['gender'],
            ':photo'      => $data['photo'],
            ':is_admin'   => $data['is_admin'],
            ':created_by' => $data['created_by'],
        ]);

        return (int)$pdo->lastInsertId();
    }
}