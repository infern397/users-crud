<?php

namespace App\Requests;

use App\Core\Request;

class LoginRequest extends Request
{
    protected function rules(): array
    {
        return [
            'email' => ['required', 'email', 'maxLength:255'],
            'password' => ['required', 'minLength:6', 'maxLength:255'],
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