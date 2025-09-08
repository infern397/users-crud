<?php

namespace App\UseCases\User;

use App\Core\Storage;
use App\Exceptions\UserAlreadyExistsException;
use App\Models\User;

class UpdateUserUseCase
{
    /**
     * @throws UserAlreadyExistsException
     */
    public static function execute(int $id, array $data): User
    {
        $user = User::findByEmail($data['email']);

        if ($user && $user->id != $id) {
            throw new UserAlreadyExistsException();
        }

        if ($data['photo']) {
            $data['photo'] = new Storage(BASE_PATH . '/public/uploads')->save($data['photo']);
        }

        $user->fill($data);
        $user->save();

        return $user;
    }
}