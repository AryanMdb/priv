<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['name','cat_id','code', 'discount_value', 'type', 'expires_at'];
    
    protected $dates = ['expires_at'];
}
