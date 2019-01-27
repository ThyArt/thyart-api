<?php

namespace App\Http\Requests\Artwork;

use App\Artwork;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArtworkIndexRequest extends FormRequest
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
            'price_min' => 'numeric',
            'price_max' => 'numeric',
            'ref' => 'string|max:255',
            'state' => ['string', Rule::in([
               Artwork::STATE_EXPOSED,
               Artwork::STATE_IN_STOCK,
               Artwork::STATE_INCOMING,
               Artwork::STATE_SOLD
            ])],
            'per_page' => 'integer'
        ];
    }
}
