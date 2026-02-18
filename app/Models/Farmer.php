<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $casts = [
        'asset_ownership' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        // Hook into the model's creating event
        static::creating(function ($farmer) {
            $farmer->farmer_id = self::generateFarmerId();
        });
    }

    // Function to generate the farmer ID
    private static function generateFarmerId()
    {
        // Get the last farmer record
        $lastFarmer = Farmer::orderBy('created_at', 'desc')->first();

        // Default starting number if no record exists
        $lastNumber = $lastFarmer ? (int)substr($lastFarmer->farmer_id, 4) : 0;

        // Increment the number for the new farmer
        $newNumber = $lastNumber + 1;

        // Format the ID as YT-0001
        return 'YT-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'first_name', 'last_name', 'date_of_birth', 'gender', 'country',
        'state_province', 'territory', 'village', 'operational_site',
        'number_of_family_members', 'contact_number', 'photo', 'bank_name',
        'account_name', 'branch', 'account_number', 'doc_type', 'doc_recto', 'doc_verso'
    ];

    // Relation with country
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    // Relation with country
    public function province()
    {
        return $this->belongsTo(Province::class, 'state_province_id');
    }

    // Relation with country
    public function territory()
    {
        return $this->belongsTo(Territory::class);
    }

    // Relation with locality
    public function groupement()
    {
        return $this->belongsTo(Groupement::class);
    }

    // Relation with Farm
    public function farms()
    {
        return $this->hasMany(Farm::class);
    }

    // Relation with CropManagement
    public function crops()
    {
        return $this->hasMany(CropManagement::class);
    }

    // Relation with Field
    public function fields()
    {
        return $this->hasMany(Field::class);
    }

    // Relation with Accompaniement
    public function accompaniement()
    {
        return $this->belongsTo(Accompaniement::class);
    }
}
