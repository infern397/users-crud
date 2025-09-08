<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\UserAlreadyExistsException;
use App\Requests\StoreUserRequest;
use App\Requests\UpdateUserRequest;
use App\UseCases\User\CreateUserUseCase;
use App\UseCases\User\DeleteUserUseCase;
use App\UseCases\User\UpdateUserUseCase;

class UserController extends Controller
{
    public function store(): void
    {
        $request = new StoreUserRequest();

        if (!$request->validate()) {
            $this->json(['errors' => $request->errors()], 422);
        }

        $data = $request->data();

        try {
            CreateUserUseCase::execute($data);
        } catch (UserAlreadyExistsException) {
            $this->json(['errors' => ['email' => ['Пользователь с таким email уже существует']]], 422);
        }

        $this->json(['message' => 'Пользователь успешно создан'], 201);
    }

    public function update(int $id): void
    {
        $request = new UpdateUserRequest();

        if (!$request->validate()) {
            $this->json(['errors' => $request->errors()], 422);
        }

        $data = $request->data();

        try {
            UpdateUserUseCase::execute($id, $data);
        } catch (UserAlreadyExistsException) {
            $this->json(['errors' => ['email' => ['Пользователь с таким email уже существует']]], 422);
        }

        $this->json(['message' => 'Пользователь обновлён']);
    }

    public function delete(int $id): void
    {
        try {
            DeleteUserUseCase::execute($id);
        } catch (EntityNotFoundException) {
            $this->json(['message' => 'Пользователь не найден'], 404);
        }

        $this->json(['message' => 'Пользователь удалён']);
    }
}