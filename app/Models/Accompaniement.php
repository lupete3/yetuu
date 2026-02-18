<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accompaniement extends Model
{
    use HasFactory;

    public function farmers()
    {
        return $this->hasMany(Farmer::class);
    }

    public function farmersAccompaniement()
    {
        return $this->hasMany(FarmerAccompaniement::class);
    }
}
