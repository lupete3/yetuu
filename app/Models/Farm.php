<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farm extends Model
{
    use HasFactory;

    protected $casts = [
        'documents_upload' => 'array',
    ];

    protected $fillable = [
        'farm_id',
        'farmer_id',
        'farm_name',
        'previous_cultivated_crop',
        'address',
        'proposed_planting_area',
        'land_topography',
        'total_land_holding',
        'land_ownership',
        'nearby',
        'gps_location',
        'photo',
        'registration_date'
    ];

    protected static function boot()
    {
        parent::boot();

        // Hook into the model's creating event
        static::creating(function ($farm) {
            $farm->farm_id = self::generateFarmId();
        });
    }

    // Function to generate the farmer ID
    private static function generateFarmId()
    {
        // Get the last farmer record
        $lastFarm = Farm::orderBy('created_at', 'desc')->first();

        // Default starting number if no record exists
        $lastNumber = $lastFarm ? (int)substr($lastFarm->farm_id, 6) : 0;

        // Increment the number for the new farmer
        $newNumber = $lastNumber + 1;

        // Format the ID as YT-0001
        return 'YFRM-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function farmLabour()
    {
        return $this->hasMany(FarmLabour::class);
    }

    public function farmConversion()
    {
        return $this->hasMany(FarmConversion::class);
    }
}
