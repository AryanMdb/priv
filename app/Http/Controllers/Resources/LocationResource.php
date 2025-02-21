<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id ?? '',
            'name' => $this->name ?? '',
            'latitude' => $this->latitude ?? '',
            'longitude' => $this->longitude ?? '',
            'address' => $this->address ?? '',
            'city' => $this->city ?? '',
            'state' => $this->state ?? '',
            'zip_code' => $this->zip_code ?? '',
            'country' => $this->country ?? '',
        ];
    }
}
