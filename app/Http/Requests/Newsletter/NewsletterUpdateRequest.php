<?php


namespace App\Http\Requests\Newsletter;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterUpdateRequest extends FormRequest
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
            'subject' => 'string|max:255',
            'description' => 'string',
            'customer_list' => array(
                'regex:/[0-9]+(,[0-9]+)*/'
            )
        ];
    }
}