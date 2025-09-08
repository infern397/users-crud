<?php

namespace App\Controllers;

use App\Core\Controller;
use App\UseCases\User\GetUsersUseCase;

class UserController extends Controller
{
    public function index(): void
    {
        $users = GetUsersUseCase::execute();
        $this->render('users/index', [
            'users' => $users,
        ]);
    }
}