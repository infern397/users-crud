<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Exceptions\AuthenticationException;
use App\Exceptions\UserAlreadyExistsException;
use App\Requests\LoginRequest;
use App\Requests\StoreUserRequest;
use App\UseCases\Auth\LoginUseCase;
use App\UseCases\Auth\RegisterUseCase;

class AuthController extends Controller
{
    public function login(): void
    {
        $request = new LoginRequest();

        if (!$request->validate()) {
            $this->json(['errors' => $request->errors()], 422);
        }

        $email = $request->input('email');
        $password = $request->input('password');

        try {
            LoginUseCase::execute($email, $password);
        } catch (AuthenticationException) {
            $this->json(['errors' => ['email' => ['Неверный email или пароль']]], 422);
        }

        $this->json(['message' => 'Успешный вход']);
    }

    public function register(): void
    {
        $request = new StoreUserRequest();

        if (!$request->validate()) {
            $this->json(['errors' => $request->errors()], 422);
        }

        try {
            RegisterUseCase::execute($request->data());
        } catch (UserAlreadyExistsException) {
            $this->json(['errors' => ['email' => ['Пользователь с таким email уже существует']]], 422);
        }

        $this->json(['message' => 'Регистрация прошла успешно'], 201);
    }
}