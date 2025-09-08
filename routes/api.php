<?php

use App\Controllers\Api\UserController;
use App\Controllers\Api\AuthController;
use App\Core\Router;

$router = Router::getInstance();

$router->post('/api/users', [UserController::class, 'store']);

$router->post('/api/auth/login', [AuthController::class, 'login']);
$router->post('/api/auth/register', [AuthController::class, 'register']);
$router->post('/api/auth/logout', [AuthController::class, 'logout']);