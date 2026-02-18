<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_staff_id',
        'field_id',
        'visit_date',
        'gps_location',
        'notes',
        'photos',
        'estimated_yield',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'field_staff_id');
    }
}
