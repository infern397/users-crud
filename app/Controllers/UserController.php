<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Storage;
use App\Models\User;
use App\Requests\StoreUserRequest;

class UserController extends Controller
{
    private Storage $storage;

    public function __construct()
    {
        $this->storage = new Storage(__DIR__ . '/../../public/uploads');
    }

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

    public function store(): void
    {
        $request = new StoreUserRequest();

        if (!$request->validate()) {
            $this->json(['errors' => $request->errors()], 422);
        }

        $data = $request->data();

        if ($data['photo']) {
            $data['photo'] = $this->storage->save($data('photo'));
        }

        User::create($data);

        $this->json(['message' => 'User created successfully'], 201);
    }
}