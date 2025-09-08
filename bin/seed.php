<?php

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

use App\Core\Database;
use Dotenv\Dotenv;

$records = [
    [
        'full_name' => 'Иван Иванов',
        'email' => 'ivan@example.com',
        'password' => password_hash('123456', PASSWORD_BCRYPT),
        'birth_year' => 1990,
        'gender' => 'male',
        'is_admin' => 1,
    ],
    [
        'full_name' => 'Мария Петрова',
        'email' => 'maria@example.com',
        'password' => password_hash('123456', PASSWORD_BCRYPT),
        'birth_year' => 1995,
        'gender' => 'female',
        'is_admin' => 0,
    ],
];

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$pdo = Database::getInstance();

echo "Seeding users table..." . PHP_EOL;

foreach ($records as $record) {
    $columns = array_keys($record);
    $placeholders = array_map(fn($c) => ":$c", $columns);

    $sql = "INSERT INTO users (" . implode(',', $columns) . ") VALUES (" . implode(',', $placeholders) . ")";
    $stmt = $pdo->prepare($sql);

    foreach ($record as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    $stmt->execute();
}

echo "Seeding completed." . PHP_EOL;
