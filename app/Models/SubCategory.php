<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'image', 
        'title', 
        'description',
        'category_id', 
        'status',
        'order'
    ];

    public $appends = ['image_with_url'];
    
    /**
     * Get the Brand Make that owns the comment.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'subcategory_id');
    }

    public function firstProduct()
    {
        return $this->hasOne(Product::class, 'subcategory_id')->oldest();
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }


    public function getImageWithUrlAttribute()
    {
        if (isset($this->image)) {
            $imagePath = 'storage/subcategory/'.$this->image;
            return url($imagePath);
        } else {
            return '';
        }

    }
}
