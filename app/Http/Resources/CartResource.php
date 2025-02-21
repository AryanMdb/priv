<?php

namespace App\Http\Resources;

use App\Models\Coupon;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $coupon = Coupon::where('id', $this->coupon_id)->first();
        return [
            'id' => $this->id ?? '',
            'total_price' => $this->total_price ?? '',
            'deliver_charges' => $this->deliver_charges ?? '',
            'grant_total' => $this->grant_total ?? '',
            'status' => $this->status ?? '',
            'category_id' => $this->category_id,
            'discount' => $this->discount ?? 0,
            'coupon_code' => $coupon->code ?? "",
            'discount_type' => $this->discount_type ?? "",
            'distance_charge' => (float) $this->distance_charge ?? 0,
            'distance' => (float) $this->distance ?? 0,
            'location_id' => $this->location_id ?? 0,
            'cart_items' => CartItemResource::collection($this->cartItems),
            
        ];
    }
}
