<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupement extends Model
{
    use HasFactory;

    public function territory()
    {
        return $this->belongsTo(Territory::class);
    }

    public function farmers()
    {
        return $this->hasMany(Farmer::class);
    }
}
