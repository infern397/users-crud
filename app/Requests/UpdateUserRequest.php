<?php

namespace App\Requests;

use App\Core\Request;

class UpdateUserRequest extends Request
{
    protected function rules(): array
    {
        return [
            'full_name'  => ['required', 'maxLength:255'],
            'email'      => ['required', 'email', 'maxLength:255'],
            'birth_year' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'gender'     => ['required'],
            'is_admin'   => ['boolean'],
            'photo'      => ['image'],
        ];
    }

    public function data(): array
    {
        return [
            'full_name'  => $this->input('full_name'),
            'email'      => $this->input('email'),
            'birth_year' => (int)$this->input('birth_year'),
            'gender'     => $this->input('gender'),
            'is_admin'   => $this->input('is_admin') ? 1 : 0,
            'photo'      => $this->hasFile('photo') ? $this->file('photo') : null,
        ];
    }
}