<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'customer_id' => $this->customer_id,
            'artwork_id' => $this->artwork_id,
            'date' => $this->date->format('Y-m-d')
        ];
    }    

    public function with($request)
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'artwork_id' => $this->artwork_id
        ];
    }


}
