<?php

namespace App\Middlewares;

use App\Core\Middleware;
use App\Core\Request;
use App\Core\UserContext;

class AdminMiddleware extends Middleware
{
    public function handle(Request $request): void
    {
        $user = UserContext::user();

        $isAdmin = $user && $user->is_admin ?? false;

        if (!$isAdmin) {
            http_response_code(403);
            exit();
        }
    }
}