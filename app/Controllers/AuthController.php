<?php

namespace App\Controllers;

use App\Core\Controller;

class AuthController extends Controller
{
    public function login(): void
    {
        $this->render('auth/login');
    }

    public function register(): void
    {
        $this->render('auth/register');
    }
}