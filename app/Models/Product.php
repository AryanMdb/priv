<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Relationships\ProductRelationship;

class Product extends Model
{
    use HasFactory, ProductRelationship;

    protected $fillable = [
        'image',
        'title',
        'description',
        'total_amount',
        'discount',
        'selling_price',
        'category_id',
        'subcategory_id',
        'out_of_stock',
        'status',
        'order',
    ];

    public $appends = ['image_with_url'];

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

    public function inventory()
    {
        return $this->hasMany(ProductInventory::class);
    }

    public function getImageWithUrlAttribute()
    {
        if (isset($this->image)) {
            $imageArray = json_decode($this->image, true);
    
            if (!$imageArray) {
                $imageArray = [$this->image];
            }
    
            return array_map(function ($image) {
                return url('storage/product/' . $image);
            }, $imageArray);
        }
    
        return [];
    }

}

