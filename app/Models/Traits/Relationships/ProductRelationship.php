<?php
namespace App\Models\Traits\Relationships;

use App\Models\Category;
use App\Models\SubCategory;

trait ProductRelationship
{

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}