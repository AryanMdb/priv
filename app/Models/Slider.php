<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    protected $fillable = [
        'image', 
        'title', 
        'status'
    ];

    public $appends = ['img_with_url'];
   
    public function getImgWithUrlAttribute()
    {
        if (isset($this->image)) {
            $imagePath = 'storage/slider/'.$this->image;
            if (file_exists($imagePath)) {
                return url($imagePath);
            }
        } else {
            return '';
        }

    }
}
