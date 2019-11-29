<?php


namespace App\Http\Resources;

use App\Artwork;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsletterResource extends JsonResource
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
            'subject' => $this->subject,
            'description' => $this->description,
            'customer_list' => CustomerResource::collection($this->customers),
            'artwork_list' => ArtworkResource::collection($this->artworks)
        ];
    }
}
