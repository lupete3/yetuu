<?php

namespace App\Exports;

use App\Models\FarmerAccompaniement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class FarmerAccompaniementExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    protected $filterSeason;
    protected $selectedYear;
    protected $selectedTypeSupport;

    /**
     * Constructeur pour accepter les paramètres de filtrage.
     */
    public function __construct($filterSeason, $selectedYear, $selectedTypeSupport)
    {
        $this->filterSeason = $filterSeason;
        $this->selectedYear = $selectedYear;
        $this->selectedTypeSupport = $selectedTypeSupport;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Construire la requête en fonction des filtres
        $query = FarmerAccompaniement::query();

        if ($this->selectedYear) {
            $query->where('year', $this->selectedYear);
        }
        if ($this->filterSeason) {
            $query->where('season', $this->filterSeason);
        }
        if ($this->selectedTypeSupport) {
            $query->where('accompaniement_id', $this->selectedTypeSupport);
        }

        return $query->get();
    }

    /**
     * Définir les en-têtes des colonnes dans le fichier Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Year',
            'Season',
            'Beneficiary Name',
            'Age',
            'Gender',
            'Country',
            'Province/State',
            'Territory',
            'Groupement',
            'Village',
            'Operational Site',
            'Phone Number',
            'GPS Coordinates',
            'Crop Sown',
            'Variety',
            'Seed Quantity Received (Kg)',
            'Fertilizer Type',
            'Basal Fertilizer Quantity Received (Kg)',
            'Top-dressing Fertilizer Quantity Received (Kg)',
            'Superficial Area Cultivated',
            'Training Sessions Received',
            'Types of Training Received',
            'Additional Support Received',
            'Quantity Produced (Kg)',
            'Quantity Reimbursed (Kg)',
            'Type Of SUpport/Activity',
            'Observations',
        ];
    }

    /**
     * Mapper les données pour chaque ligne du fichier Excel.
     *
     * @param mixed $farmerAccompaniement
     * @return array
     */
    public function map($farmerAccompaniement): array
    {
        return [
            $farmerAccompaniement->id,
            $farmerAccompaniement->year,
            $farmerAccompaniement->season,
            $farmerAccompaniement->beneficiary_name,
            $farmerAccompaniement->age ?? 'N/A',
            $farmerAccompaniement->gender ?? 'N/A',
            $farmerAccompaniement->country ?? 'N/A',
            $farmerAccompaniement->province ?? 'N/A',
            $farmerAccompaniement->territory ?? 'N/A',
            $farmerAccompaniement->groupement ?? 'N/A',
            $farmerAccompaniement->village ?? 'N/A',
            $farmerAccompaniement->site ?? 'N/A',
            $farmerAccompaniement->phone_number ?? 'N/A',
            $farmerAccompaniement->gps_coordinates ?? 'N/A',
            $farmerAccompaniement->crop_sown ?? 'N/A',
            $farmerAccompaniement->variety ?? 'N/A',
            $farmerAccompaniement->seed_quantity_received ?? 'N/A',
            $farmerAccompaniement->fertilizer_type ?? 'N/A',
            $farmerAccompaniement->fertilizer_quantity_base ?? 'N/A',
            $farmerAccompaniement->fertilizer_quantity_surface ?? 'N/A',
            $farmerAccompaniement->cultivated_area ?? 'N/A',
            $farmerAccompaniement->training_sessions_received ?? 'N/A',
            $farmerAccompaniement->training_types_received ?? 'N/A',
            $farmerAccompaniement->additional_support_received ?? 'N/A',
            $farmerAccompaniement->quantity_produced ?? 'N/A',
            $farmerAccompaniement->quantity_reimbursed ?? 'N/A',
            $farmerAccompaniement->accompaniement->name ?? 'N/A',
            $farmerAccompaniement->observations ?? 'N/A',
        ];
    }
}
