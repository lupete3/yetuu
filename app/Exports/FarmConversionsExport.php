<?php

namespace App\Exports;

use App\Models\FarmConversion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FarmConversionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return FarmConversion::with('farm') // Chargement des relations
            ->get()
            ->map(function($farmconversion) {
                return [
                    'farm_name' => $farmconversion->farm->farm_name,
                    'last_date_chemical_applied' => $farmconversion->last_date_chemical_applied ?? 'N/A',
                    'estimated_yield' => $farmconversion->estimated_yield ?? 'N/A',
                    'conventional_lands' => $farmconversion->conventional_lands ?? 'N/A',
                    'conventional_crops' => $farmconversion->conventional_crops ?? 'N/A',
                    'inspector_name' => $farmconversion->inspector_name ?? 'N/A',
                    'qualified_inspector' => $farmconversion->qualified_inspector ? 'Yes' : 'No',
                    'date_of_inspection' => $farmconversion->date_of_inspection ?? 'N/A',
                    // Ajoutez d'autres colonnes nécessaires ici, sauf les clés étrangères directes
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Farm Name',
            'last_date_chemical_applied',
            'estimated_yield',
            'conventional_lands',
            'conventional_crops',
            'inspector_name',
            'qualified_inspector',
            'date_of_inspection'
            // Ajoutez ici les en-têtes pour toutes les colonnes sélectionnées
        ];
    }
}
