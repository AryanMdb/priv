<?php

namespace App\Models\Traits\Attributes;
use Illuminate\Support\Facades\Hash;

trait UserAttribute
{
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getGenderTypeAttribute(){
        return $this->gender == 'male' ? 'Male' : ($this->gender == 'female' ? 'Female' : ($this->gender == 'other' ? 'Other' : ''));
    }

    public function getImageWithUrlAttribute()
    {
        if (isset($this->image)) {
            $imagePath = 'storage/profile_image/'.$this->image;
            return asset($imagePath);
        } else {
            return '';
        }

    }

}