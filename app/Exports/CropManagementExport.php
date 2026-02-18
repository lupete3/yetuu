<?php

namespace App\Exports;

use App\Models\CropManagement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CropManagementExport implements FromCollection, WithHeadings
{
    /**
     * Retourne une collection des données à exporter.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return CropManagement::with('farmer') // Charger la relation avec le fermier
            ->get()
            ->map(function ($cropManagement) {
                return [
                    'crop_id' => $cropManagement->crop_id ?? 'N/A',
                    'farmer_name' => $cropManagement->farmer ? $cropManagement->farmer->last_name . ' ' . $cropManagement->farmer->first_name : 'N/A',
                    'growing_season' => $cropManagement->growing_season ?? 'N/A',
                    'crop_type' => $cropManagement->crop_type ?? 'N/A',
                    'variety_name' => $cropManagement->variety_name ?? 'N/A',
                    'disease_resistance' => $cropManagement->disease_resistance ?? 'N/A',
                    'growth_duration' => $cropManagement->growth_duration ?? 'N/A',
                    'fertilizer_requirements' => $cropManagement->fertilizer_requirements ?? 'N/A',
                    'planting_date' => $cropManagement->planting_date ? $cropManagement->planting_date : 'N/A',
                    'harvest_date' => $cropManagement->harvest_date ? $cropManagement->harvest_date : 'N/A',
                    'growth_stage' => $cropManagement->growth_stage ?? 'N/A',
                    'created_at' => $cropManagement->created_at ? $cropManagement->created_at : 'N/A',
                ];
            });
    }

    /**
     * Définit les en-têtes pour le fichier Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Crop ID',
            'Farmer Name',
            'Growing Season',
            'Crop Type',
            'Variety Name',
            'Disease Resistance',
            'Growth Duration (days)',
            'Fertilizer Requirements',
            'Sowing Date',
            'Harvest Date',
            'Growth Stage',
            'Created At',
        ];
    }
}
