<?php

namespace App\UseCases\User;

use App\Core\Storage;
use App\Core\UserContext;
use App\Exceptions\UserAlreadyExistsException;
use App\Models\User;

class CreateUserUseCase
{
    /**
     * @throws UserAlreadyExistsException
     */
    public static function execute(array $data): User
    {
        if (User::findByEmail($data['email'])) {
            throw new UserAlreadyExistsException();
        }

        if ($data['photo']) {
            $data['photo'] = new Storage(BASE_PATH . '/public/uploads')->save($data['photo']);
        }

        $data['created_by'] = UserContext::id();

        $user = new User($data);
        $user->save();

        return $user;
    }
}