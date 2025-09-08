<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\UserContext;

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

    public function logout(): void
    {
        UserContext::logout();
        $this->redirect('/login');
    }
}