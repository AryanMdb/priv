<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => $this->id ?? '',
            'name' => $this->name ?? '',
            'phone' => $this->phone ?? '',
            'gender' => $this->gender ?? '',
            'device_token' => $this->device_token ?? '',
            'lang' => $this->lang ?? '',
            'role' => $this->role ?? '',
            'location' => $this->location ?? '',
            'latitude' => $this->latitude ?? '',
            'longitude' => $this->longitude ?? '',
            'automatic_location' => $this->automatic_location ?? '',
            'status' => $this->status ?? '',
            'image' => $this->image_with_url ?? ''
        ];
    }
}
