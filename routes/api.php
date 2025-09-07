<?php

use App\Controllers\Api\UserController;
use App\Core\Router;

$router = Router::getInstance();

$router->post('/api/users', [UserController::class, 'store']);