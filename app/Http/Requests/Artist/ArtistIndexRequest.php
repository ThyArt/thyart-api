<?php

namespace App\Http\Requests\Artist;

use Illuminate\Foundation\Http\FormRequest;

class ArtistIndexRequest extends FormRequest
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
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'string|max:255',
            'phone' => 'string|max:255',
            'address' => 'string|max:255',
            'city' => 'string|max:255',
            'country' => 'string|max:255',
            'per_page' => 'integer'
        ];
    }
}
