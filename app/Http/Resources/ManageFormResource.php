<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManageFormResource extends JsonResource
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
            'category_id' => $this->category_id ?? '',
            'category' => $this?->category?->title ?? '',
            'manage_fields' => ManageFieldsResource::collection($this->manageFields)
        ];
    }
}
