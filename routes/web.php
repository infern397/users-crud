<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Core\Router;
use App\Middlewares\AuthMiddleware;

$router = Router::getInstance();

$router->get('/', [UserController::class, 'index'])->middleware([AuthMiddleware::class]);
$router->get('/users', [UserController::class, 'index'])->middleware([AuthMiddleware::class]);
$router->get('/users/{id}', [UserController::class, 'show'])->middleware([AuthMiddleware::class]);

$router->get('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'register']);
$router->get('/logout', [AuthController::class, 'logout']);