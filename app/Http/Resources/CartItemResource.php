<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'product' => new ProductResource($this->product) ?? '',
            'product_id' => $this->product_id ?? '',
            'cart_id' => $this->cart_id ?? '',
            'inventory_id' => $this->inventory_id ?? '',
            'item_price' => $this->item_price ?? '',
            'item_quantity' => $this->item_quantity ?? '',
            'no_of_items' => $this->no_of_items ?? '',
        ];
    }
}
