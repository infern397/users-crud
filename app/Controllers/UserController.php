<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index(): void
    {
        $users = User::all();
        $this->render('users/index', [
            'users' => $users,
        ]);
    }

    public function show(int $id): void
    {
        echo "User details for ID = {$id}";
    }
}