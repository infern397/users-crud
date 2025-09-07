<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = Database::getInstance();
$migrations = glob(__DIR__ . '/../database/migrations/*.php');

foreach ($migrations as $file) {
    $sql = require $file;
    echo "Running migration: " . basename($file) . PHP_EOL;
    $pdo->exec($sql);
}