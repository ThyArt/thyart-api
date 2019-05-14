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
        $customer = Customer::find($this->customer_id);
        $artwork = Artwork::find($this->artwork_id);

        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'customer_first_name' => $customer->first_name,
            'customer_last_name' => $customer->last_name,
            'customer_phone' => $customer->phone,
            'customer_email' => $customer->email,
            'customer_address' => $customer->address,
            'customer_city' => $customer->city,
            'customer_country' => $customer->country,
            'artwork_id' => $this->artwork_id,
            'artwork_name' => $artwork->name,
            'artwork_price' => $artwork->price,
            'artwork_ref' => $artwork->ref,
            'artwork_state' => $artwork->state,
            'artwork_images' => MediaResource::collection($artwork->getMedia('images'))
        ];    
    }
}
