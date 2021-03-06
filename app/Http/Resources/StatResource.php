<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatResource extends JsonResource
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
            "daily" => $this->daily,
            "weekly" => "integer",
            "monthly" => "integer",
            "trimester" => "integer",
            "semester" => "integer",
            "yearly" => "integer"
        ];
    }
}
