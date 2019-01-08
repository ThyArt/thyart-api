<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserIndexRequest extends FormRequest
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
            'email' => 'string|max:255',
            'per_page' => 'integer'
        ];
    }
}
