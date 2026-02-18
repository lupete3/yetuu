<?php

namespace App\Exports;

use App\Models\FarmLabour;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FarmLaboursExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return FarmLabour::with('farm') // Chargement des relations
            ->get()
            ->map(function($farmlabour) {
                return [
                    'farm_name' => $farmlabour->farm->farm_name,
                    'full_time_workers' => $farmlabour->full_time_workers,
                    'seasonal_workers' => $farmlabour->seasonal_workers,
                    'part_time_workers' => $farmlabour->part_time_workers,
                    // Ajoutez d'autres colonnes nécessaires ici, sauf les clés étrangères directes
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Farm Name',
            'Full time works',
            'Seasonal works',
            'Part time works',
            // Ajoutez ici les en-têtes pour toutes les colonnes sélectionnées
        ];
    }
}
