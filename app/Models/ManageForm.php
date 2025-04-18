<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageForm extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function manageFields()
    {
        return $this->hasMany(ManageField::class, 'manage_form_id');
    }
}
