<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'urls' => [
                'origin' => $this->getFullUrl(),
                'small' => $this->getFullUrl('small'),
                'medium' => $this->getFullUrl('medium'),
                'large' => $this->getFullUrl('large'),
                'xlarge' => $this->getFullUrl('xlarge'),
            ],
            'name' => $this->name,
            'file_name' => $this->file_name
        ];
    }
}
