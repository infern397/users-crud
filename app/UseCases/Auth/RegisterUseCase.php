<?php

namespace App\UseCases\Auth;

use App\Core\Session;
use App\Core\Storage;
use App\Exceptions\UserAlreadyExistsException;
use App\Models\User;

class RegisterUseCase
{
    /**
     * @throws UserAlreadyExistsException
     */
    public static function execute(array $data): void
    {
        if (User::findByEmail($data['email'])) {
            throw new UserAlreadyExistsException();
        }

        if ($data['photo']) {
            $data['photo'] = new Storage(BASE_PATH . '/public/uploads')->save($data('photo'));
        }

        $data['created_by'] = null;

        $user = new User($data);
        $user->save();

        Session::set('user_id', $user->id);
    }
}