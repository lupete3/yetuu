<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropManagement extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        // Hook into the model's creating event
        static::creating(function ($crop) {
            $crop->crop_id = self::generateCropdId();
        });
    }

    // Function to generate the field ID
    private static function generateCropdId()
    {
        // Get the last field record
        $lastCrop = CropManagement::orderBy('created_at', 'desc')->first();

        // Default starting number if no record exists
        $lastNumber = $lastCrop ? (int)substr($lastCrop->crop_id, 4) : 0;

        // Increment the number for the new crop
        $newNumber = $lastNumber + 1;

        // Format the ID as FT-0001
        return 'CT-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'growing_season',
        'crop_id',
        'farmer_id',
        'crop_type',
        'variety_name',
        'disease_resistance',
        'growth_duration',
        'fertilizer_requirements',
        'planting_date',
        'harvest_date',
        'growth_stage',
        'photo'
    ];

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }
}
