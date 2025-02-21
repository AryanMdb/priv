<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class location extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'location','name', 'phone', 'area', 'landmark', 'pincode', 'city', 'default_address', 'type', 'latitude', 'longitude'];
}
