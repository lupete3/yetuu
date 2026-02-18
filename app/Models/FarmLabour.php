<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmLabour extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'full_time_workers',
        'seasonal_workers',
        'part_time_workers'
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}
