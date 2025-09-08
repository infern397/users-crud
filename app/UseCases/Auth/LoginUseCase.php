<?php

namespace App\UseCases\Auth;

use App\Core\Session;
use App\Exceptions\AuthenticationException;
use App\Models\User;

class LoginUseCase
{
    /**
     * @throws AuthenticationException
     */
    public static function execute(string $email, string $password): void
    {
        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            throw new AuthenticationException();
        }

        Session::set('user_id', $user->id);
    }
}