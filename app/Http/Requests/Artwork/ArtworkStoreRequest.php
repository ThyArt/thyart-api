<?php

namespace App\Http\Requests\Artwork;

use App\Artwork;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ArtworkStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'ref' => 'required|string|max:255',
            'state' => ['required','string', Rule::in([
                Artwork::STATE_EXPOSED,
                Artwork::STATE_IN_STOCK,
                Artwork::STATE_INCOMING,
                Artwork::STATE_SOLD
            ])],
            'artist_id' => 'required|numeric',
            'image' => 'array',
        ];
    }
}
