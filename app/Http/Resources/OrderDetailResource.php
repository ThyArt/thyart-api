<?php

namespace App\Http\Resources;

use App\Customer;
use App\Artwork;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'customer' => new CustomerResource($this->customer),
            'artwork' => new ArtworkResource($this->artwork),
            'date' => $this->date->format('Y-m-d')
        ];
    }
}
