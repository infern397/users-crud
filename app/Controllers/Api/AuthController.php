<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Core\Session;
use App\Core\Storage;
use App\Models\User;
use App\Requests\LoginRequest;
use App\Requests\StoreUserRequest;

class AuthController extends Controller
{
    private Storage $storage;

    public function __construct()
    {
        $this->storage = new Storage(BASE_PATH . '/public/uploads');
    }

    public function login(): void
    {
        $request = new LoginRequest();

        if (!$request->validate()) {
            $this->json(['errors' => $request->errors()], 422);
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->json(['errors' => ['email' => ['Неверный email или пароль']]], 422);
        }

        Session::set('user_id', $user['id']);

        $this->json(['message' => 'Успешный вход']);
    }

    public function register(): void
    {
        $request = new StoreUserRequest();

        if (!$request->validate()) {
            $this->json(['errors' => $request->errors()], 422);
        }

        $data = $request->data();

        if (User::findByEmail($data['email'])) {
            $this->json(['errors' => ['email' => ['Пользователь с таким email уже существует']]], 422);
        }

        if ($data['photo']) {
            $data['photo'] = $this->storage->save($data('photo'));
        }

        $data['created_by'] = null;

        $userId = User::create($data);

        Session::set('user_id', $userId);

        $this->json(['message' => 'Регистрация прошла успешно'], 201);
    }
}