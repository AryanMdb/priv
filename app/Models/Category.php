<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'title', 'description', 'status', 'is_show', 'coming_soon','order','min_value','max_value','delivery_charge','delivery_time'];

    public $appends = ['image_with_url', 'is_show_form'];

    /**
     * Get the make model for the blog post.
     */
    public function subCategory()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function productsAndSubcategory()
    {
        return $this->hasManyThrough(Product::class, SubCategory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function manageFormCategory()
    {
        return $this->hasMany(ManageForm::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function getImageWithUrlAttribute()
    {
        if (isset($this->image)) {
            $imagePath = 'storage/category/'.$this->image;
            return url($imagePath);
        } else {
            return '';
        }
    }

    public function getIsShowFormAttribute(){
        return $this->is_show == 1 ? true : false;
    }

}
