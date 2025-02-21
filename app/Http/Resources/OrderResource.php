<?php

namespace App\Http\Resources;
use App\Models\Location;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $locationId = $this?->cart?->location_id;
        $location = Location::find($locationId);
  
        return [
            'id' => $this->id ?? '',
            'user_id' => $this->user_id ?? '',
            'order_id' => $this->order_id ?? '',
            'name' => $this->name ?? '',
            'phone_no' => $this->phone_no ?? '',
            'latitude' => $this->latitude ?? '',
            'longitude' => $this->longitude ?? '',
            'description' => $this->description ?? '',
            'status' => $this->status ?? '',
            'delivery_date' => isset($this->delivery_date) ? $this->delivery_date : '',
            'address_to' => $this->address_to ?? '',
            'address_from' => $this->address_from ?? '',
            'property_address' => $this->property_address ?? '',
            'property_details' => $this->property_details ?? '',
            'expected_cost' => $this->expected_cost ?? '',
            'phone_company' => $this->phone_company ?? '',
            'phone_model' => $this->phone_model ?? '',
            'expected_rent' => $this->expected_rent ?? '',
            'preferred_location' => $this->preferred_location ?? '',
            'required_property_details' => $this->required_property_details ?? '',
            'date_of_journey' => $this->date_of_journey ?? null,
            'time_of_journey' => $this->time_of_journey ?? '',
            'approximate_load' => $this->approximate_load ?? '',
            'estimated_work_hours' => $this->estimated_work_hours ?? '',
            'no_of_passengers' => $this->no_of_passengers ?? '',
            'estimated_distance' => $this->estimated_distance ?? '',
            'total_orchard_area' => $this->total_orchard_area ?? '',
            'age_of_orchard' => $this->age_of_orchard ?? '',
            'type_of_fruit_plant' => $this->type_of_fruit_plant ?? '',
            'total_estimated_weight' => $this->total_estimated_weight ?? '',
            'expected_demanded_total_cost' => $this->expected_demanded_total_cost ?? '',
            'product_name_model' => $this->product_name_model ?? '',
            'month_year_of_purchase' => $this->month_year_of_purchase ?? '',
            'product_brand' => $this->product_brand ?? '',
            'expected_demanded_price' => $this->expected_demanded_price ?? '',
            'created_at' => isset($this->created_at) ? $this->created_at : '',
            'cart' => new CartResource($this?->cart),
            'location' => $location ?? null,
        ];
    }
}
