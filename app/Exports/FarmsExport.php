<?php

namespace App\Exports;

use App\Models\Farm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FarmsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Farm::with('farmer') // Chargement des relations
            ->get()
            ->map(function($farm) {
                return [
                    'farm_id' => $farm->farm_id,
                    'farmer_name' => $farm->farmer->first_name . ' ' . $farm->farmer->last_name,
                    'farm_name' => $farm->farm_name,
                    'previous_cultivated_crop' => $farm->previous_cultivated_crop,
                    'address' => $farm->address,
                    'proposed_planting_area' => $farm->proposed_planting_area,
                    'land_topography' => $farm->land_topography,
                    'total_land_holding' => $farm->total_land_holding,
                    'land_ownership' => $farm->land_ownership,
                    'nearby' => $farm->nearby,
                    'gps_location' => $farm->gps_location,
                    'registration_date' => $farm->registration_date,
                    // Ajoutez d'autres colonnes nécessaires ici, sauf les clés étrangères directes
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Farm ID',
            'Farmer Name',
            'Farm Name',
            'Previous Cultivated Crop',
            'Address',
            'Proposed Planting Area',
            'Land Topography',
            'Total Land Holding',
            'Land Ownership',
            'Nearby',
            'GPS Location',
            'Registration Date',
            // Ajoutez ici les en-têtes pour toutes les colonnes sélectionnées
        ];
    }
}
