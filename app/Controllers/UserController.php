<?php

namespace App\Controllers;

use App\Core\Controller;

class UserController extends Controller
{
    public function index(): void
    {
        $this->render('users/index', ['message' => 'Welcome to the User Index Page!']);
    }

    public function show(int $id): void
    {
        echo "User details for ID = {$id}";
    }

    public function store(): void
    {
        echo "Store new user";
    }
}