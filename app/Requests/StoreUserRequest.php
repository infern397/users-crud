<?php

namespace App\Requests;

use App\Core\Request;

class StoreUserRequest extends Request
{
    protected function rules(): array
    {
        return [
            'full_name'  => ['required'],
            'birth_year' => ['required', 'integer'],
            'gender'     => ['required'],
            'is_admin'   => ['boolean'],
        ];
    }

    public function data(): array
    {
        return [
            'full_name'  => $this->input('full_name'),
            'birth_year' => (int)$this->input('birth_year'),
            'gender'     => $this->input('gender'),
            'is_admin'   => $this->input('is_admin') ? 1 : 0,
            'photo'      => $this->hasFile('photo') ? null : $this->file('photo'),
            'created_by' => 1,
        ];
    }

}