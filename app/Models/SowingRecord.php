<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SowingRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_id',
        'crop_id',
        'sowing_date',
        'area_sown',
        'gps_coordinates',
        'geo_map_url'
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function crop()
    {
        return $this->belongsTo(CropManagement::class);
    }
}
