<?php

namespace App\Exports;

use App\Models\Field;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FieldExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Field::with('farmer') // Load the farmer relationship
            ->get()
            ->map(function($field) {
                return [
                    'field_id' => $field->field_id,
                    'farmer_name' => $field->farmer->first_name . ' ' . $field->farmer->last_name, // Farmer's full name
                    'field_name' => $field->field_name,
                    'total_area' => $field->total_area,
                    'soil_type' => $field->soil_type,
                    'irrigation_type' => $field->irrigation_type,
                    'registration_date' => $field->registration_date,
                    // Add more columns as needed
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Land Plot ID',
            'Farmer Name',
            'Land Plot Name',
            'Total Area',
            'Soil Type',
            'Irrigation Type',
            'Registration Date',
            // Add headings for any additional columns
        ];
    }
}
