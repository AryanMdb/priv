<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubcategoryResource extends JsonResource
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
            'category' => $this?->category?->title ?? '',
            'category_id' => $this->category_id ?? '',
            'title' => $this->title ?? '',
            'image' => $this->image ?? '',
            'image_with_url' => $this->image_with_url ?? '',
            'product_id' => $this?->firstProduct?->id ?? null
        ];
    }
}
