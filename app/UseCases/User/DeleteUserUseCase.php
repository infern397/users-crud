<?php

namespace App\UseCases\User;

use App\Core\Storage;
use App\Exceptions\EntityNotFoundException;
use App\Models\User;

class DeleteUserUseCase
{
    /**
     * @throws EntityNotFoundException
     */
    public static function execute(int $id): void
    {
        $user = User::find($id);

        if (!$user) {
            throw new EntityNotFoundException();
        }

        $user->delete();

        if ($user->photo) {
            new Storage(BASE_PATH . '/public/uploads')->delete($user->photo);
        }
    }
}