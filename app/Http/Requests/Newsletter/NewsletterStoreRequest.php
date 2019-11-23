<?php


namespace App\Http\Requests\Newsletter;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterStoreRequest extends FormRequest
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
            'subject' => 'required|string|max:255',
            'description' => 'required|string|max:750',
            'customer_list' => array(
                'required',
                'regex:/[0-9]+(,[0-9]+)*/'
            ),
            'artwork_list' => array(
                'regex:/[0-9]+(,[0-9]+)*/'
            )
        ];
    }
}
