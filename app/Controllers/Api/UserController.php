<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Core\Storage;
use App\Core\UserContext;
use App\Models\User;
use App\Requests\StoreUserRequest;
use App\Requests\UpdateUserRequest;

class UserController extends Controller
{
    private Storage $storage;

    public function __construct()
    {
        $this->storage = new Storage(__DIR__ . '/../../../public/uploads');
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

        $data['created_by'] = UserContext::id();

        User::create($data);

        $this->json(['message' => 'User created successfully'], 201);
    }

    public function update(int $id): void
    {
        $request = new UpdateUserRequest();

        if (!$request->validate()) {
            $this->json(['errors' => $request->errors()], 422);
        }

        $data = $request->data();

        if ($data['photo']) {
            $data['photo'] = $this->storage->save($data('photo'));
        }

        User::update($id, $data);

        $this->json(['message' => 'Пользователь обновлён']);
    }
}