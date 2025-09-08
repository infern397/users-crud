<?php

use App\Controllers\Api\UserController;
use App\Controllers\Api\AuthController;
use App\Core\Router;
use App\Middlewares\AdminMiddleware;
use App\Middlewares\AuthMiddleware;

$router = Router::getInstance();

$router->post('/api/users', [UserController::class, 'store'])->middleware([AuthMiddleware::class]);
$router->post('/api/users/{id}/update', [UserController::class, 'update'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);
$router->post('/api/users/{id}/delete', [UserController::class, 'delete'])->middleware([AuthMiddleware::class, AdminMiddleware::class]);

$router->post('/api/auth/login', [AuthController::class, 'login']);
$router->post('/api/auth/register', [AuthController::class, 'register']);
$router->post('/api/auth/logout', [AuthController::class, 'logout']);