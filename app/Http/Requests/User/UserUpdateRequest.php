<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string|max:255',
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'role' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $this->user()->id,
            'password' => 'string|min:6',
        ];
    }
}
