<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerAccompaniement extends Model
{
    use HasFactory;

    public function accompaniement()
    {
        return $this->belongsTo(Accompaniement::class);
    }
}
