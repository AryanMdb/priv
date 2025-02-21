<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use HasFactory;
    use SoftDeletes; // Enable Soft Deletes
    protected $fillable = [
        'user_id',
        'cart_id',
        'order_id',
        'role_id',
        'name',
        'phone_no',
        'location_id',
        'status',
        'description',
        'address_to',
        'address_from',
        'property_address',
        'property_details',
        'expected_cost',
        'delivery_date',
        'phone_company',
        'phone_model',
        'expected_rent',
        'preferred_location',
        'required_property_details',
        'date_of_journey',
        'time_of_journey',
        'approximate_load',
        'estimated_work_hours',
        'no_of_passengers',
        'estimated_distance',
        'total_orchard_area',
        'age_of_orchard',
        'type_of_fruit_plant',
        'total_estimated_weight',
        'expected_demanded_total_cost',
        'product_name_model',
        'month_year_of_purchase',
        'product_brand',
        'expected_demanded_price',
        'deleted_at'
    ];


    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
