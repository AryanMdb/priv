<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageField extends Model
{
    use HasFactory;
    protected $fillable = [
        'manage_form_id',
        'category_id',
        'input_field',
    ];

    public function manageForm()
    {
        return $this->belongsTo(ManageForm::class, 'manage_form_id');
    }
}
