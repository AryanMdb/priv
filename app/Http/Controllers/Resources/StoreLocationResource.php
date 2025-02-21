<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\GoogleMapsService;

class StoreLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $googleMapsService = app(GoogleMapsService::class);
        return [
            'id' => $this->id ?? '',
            'latitude' => $this->latitude ?? '',
            'longitude' => $this->longitude ?? '',
            'address' => $googleMapsService->getAddressFromCoordinates($this->latitude, $this->longitude),
            'delivery_radius' => $this->delivery_radius ?? '',
        ];
    }
}
