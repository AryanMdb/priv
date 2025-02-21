<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'category_id',
        'total_price', 
        'deliver_charges',
        'grant_total',
        'status',
        'coupon_id',
        'discount',
        'discount_type',
        'distance_charge',
        'distance',
        'location_id',
        'coupon_code'
    ];

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function location()
{
    return $this->belongsTo(Location::class, 'location_id');
}
}
