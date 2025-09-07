<?php
use App\Core\Router;

require __DIR__ . '/../vendor/autoload.php';

require __DIR__ . '/../routes/web.php';

try {
    Router::getInstance()->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo "Error: " . $e->getMessage();
}