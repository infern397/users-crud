<?php

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

use App\Core\Database;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

$pdo = Database::getInstance();
$migrations = glob(BASE_PATH . '/database/migrations/*.php');

foreach ($migrations as $file) {
    $sql = require $file;
    echo "Running migration: " . basename($file) . PHP_EOL;
    $pdo->exec($sql);
}