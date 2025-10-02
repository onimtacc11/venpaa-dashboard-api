<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'            => $this->id,
            'loca_code'     => $this->loca_code,
            'loca_name'     => $this->loca_name,
            'location_type' => $this->location_type,
            'delivery_address' => $this->delivery_address,
            'is_active'     => $this->is_active,
            'logged_in'     => $this->logged_in,
        ];
    }
}