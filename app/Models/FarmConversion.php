<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmConversion extends Model
{
    use HasFactory;

    protected $fillable = [
        'farm_id',
        'last_date_chemical_applied',
        'estimated_yield',
        'conventional_lands',
        'conventional_crops',
        'inspector_name',
        'qualified_inspector',
        'date_of_inspection'
    ];

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }
}
