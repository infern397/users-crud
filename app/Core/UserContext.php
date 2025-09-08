<?php

namespace App\Core;

use App\Models\User;

class UserContext
{
    private static ?User $user = null;

    public static function load(): void
    {
        $userId = Session::get('user_id');
        if ($userId) {
            self::$user = User::find($userId);
        }
    }

    public static function user(): ?User
    {
        return self::$user;
    }

    public static function check(): bool
    {
        return self::$user !== null;
    }

    public static function id(): ?int
    {
        return self::$user->id ?? null;
    }

    public static function logout(): void
    {
        Session::remove('user_id');
        self::$user = null;
    }
}