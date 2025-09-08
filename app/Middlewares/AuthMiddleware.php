<?php

namespace App\Middlewares;

use App\Core\Middleware;
use App\Core\Request;
use App\Core\UserContext;

class AuthMiddleware extends Middleware
{
    public function handle(Request $request): void
    {
        if (!UserContext::check()) {
            http_response_code(401);
            header('Location: /login');
            exit();
        }
    }
}