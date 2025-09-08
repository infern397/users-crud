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
            $storage = new Storage(BASE_PATH . '/public/uploads');

            if ($user->photo) {
                $storage->delete($user->photo);
            }

            $data['photo'] = $storage->save($data['photo']);
        } else {
            $data['photo'] = User::find($id)->photo;
        }

        $user->fill($data);
        $user->save();

        return $user;
    }
}