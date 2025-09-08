<?php
use App\Core\Router;
use App\Core\UserContext;
use Dotenv\Dotenv;

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

require BASE_PATH . '/routes/web.php';
require BASE_PATH . '/routes/api.php';

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

UserContext::load();

try {
    Router::getInstance()->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo "Error: " . $e->getMessage();
}