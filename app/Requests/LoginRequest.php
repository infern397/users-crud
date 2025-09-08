<?php

namespace App\Requests;

use App\Core\Request;

class LoginRequest extends Request
{
    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'minLength:6'],
        ];
    }

    public function data(): array
    {
        return [
            'email' => $this->input('email'),
            'password' => $this->input('password'),
        ];
    }
}