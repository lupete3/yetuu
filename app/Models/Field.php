<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        // Hook into the model's creating event
        static::creating(function ($field) {
            $field->field_id = self::generateFieldId();
        });
    }

    // Function to generate the field ID
    private static function generateFieldId()
    {
        // Get the last field record
        $lastField = Field::orderBy('created_at', 'desc')->first();

        // Default starting number if no record exists
        $lastNumber = $lastField ? (int)substr($lastField->field_id, 4) : 0;

        // Increment the number for the new field
        $newNumber = $lastNumber + 1;

        // Format the ID as FT-0001
        return 'LP-' . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    // Relation with farmer
    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function fieldvisit()
    {
        return $this->hasMany(FieldVisit::class);
    }
}
