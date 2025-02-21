<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreLocation extends Model
{
    use HasFactory;
    protected $fillable = [
        'latitude',
        'longitude',
        'delivery_radius',
        'distance',
        'distance_charge',
    ];
}
