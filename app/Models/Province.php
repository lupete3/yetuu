<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    public function territories()
    {
        return $this->hasMany(Territory::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    public function farmers()
    {
        return $this->hasMany(Farmer::class);
    }
}
