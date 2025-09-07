<?php

use App\Controllers\AuthController;
use App\Controllers\UserController;
use App\Core\Router;

$router = Router::getInstance();

$router->get('/', [UserController::class, 'index']);
$router->get('/users', [UserController::class, 'index']);
$router->get('/users/{id}', [UserController::class, 'show']);

$router->get('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'register']);