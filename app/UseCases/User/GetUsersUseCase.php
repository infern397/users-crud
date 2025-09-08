<?php

namespace App\UseCases\User;

use App\Models\User;

class GetUsersUseCase
{
    /**
     * @return array<User>
     */
    public static function execute(): array
    {
        return User::all();
    }
}