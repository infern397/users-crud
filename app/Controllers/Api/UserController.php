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
        $this->storage = new Storage(BASE_PATH . '/public/uploads');
    }

    public function store(): void
    {
        $request = new StoreUserRequest();

        if (!$request->validate()) {
            $this->json(['errors' => $request->errors()], 422);
        }

        $data = $request->data();

        if (User::findByEmail($data['email'])) {
            $this->json(['errors' => ['email' => ['Email уже используется']]], 422);
        }

        if ($data['photo']) {
            $data['photo'] = $this->storage->save($data('photo'));
        }

        $data['created_by'] = UserContext::id();

        $user = new User($data);
        $user->save();

        $this->json(['message' => 'User created successfully'], 201);
    }

    public function update(int $id): void
    {
        $request = new UpdateUserRequest();

        if (!$request->validate()) {
            $this->json(['errors' => $request->errors()], 422);
        }

        $data = $request->data();

        $user = User::findByEmail($data['email']);

        if ($user && $user->id != $id) {
            $this->json(['errors' => ['email' => ['Email уже используется']]], 422);
        }

        if ($data['photo']) {
            $data['photo'] = $this->storage->save($data('photo'));
        }

        $user->fill($data);
        $user->save();

        $this->json(['message' => 'Пользователь обновлён']);
    }
}