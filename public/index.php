<?php
use App\Core\Router;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../routes/web.php';
require __DIR__ . '/../routes/api.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

try {
    Router::getInstance()->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo "Error: " . $e->getMessage();
}