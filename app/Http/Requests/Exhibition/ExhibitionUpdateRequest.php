<?php


namespace App\Http\Requests\Exhibition;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionUpdateRequest extends FormRequest
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
            'begin' => 'date',
            'end' => 'date|after:begin',
        ];
    }
}
