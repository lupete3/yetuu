<?php

namespace App\Http\Controllers;

use App\Models\FarmerAccompaniement;
use App\Exports\FarmerAccompaniementExport; // Assurez-vous que cette classe existe pour l'exportation Excel
use App\Models\Accompaniement;
use App\Models\Country;
use App\Models\Farmer;
use Barryvdh\DomPDF\Facade\Pdf; // Pour générer des PDFs
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use function PHPSTORM_META\map;

class FarmerAccompaniementController extends Controller
{
    /**
     * Afficher la liste des accompagnements des agriculteurs.
     */
    public function index(Request $request)
    {
        $viewData = [];
        $viewData['title'] = 'List of Farmer Supports';

        // Récupérer les paramètres de filtrage
        $filterSeason = $request->input('filter_type', 'A'); // Par défaut : journalier
        $selectedYear = $request->input(key: 'year');
        $selectedTypeSupport = $request->input(key: 'typeSupport');
        $selectedCountry = $request->input(key: 'country');


        // Construire la requête en fonction du type de filtre
        $query = FarmerAccompaniement::with('accompaniement');

        if ($selectedYear) {
            $query->where('year', $selectedYear);

        }
        if ($filterSeason) {
            $query->where('season', $filterSeason);
        }
        if ( $selectedTypeSupport) {
            $query->where('accompaniement_id', $selectedTypeSupport);
        }
        if ( $selectedCountry) {
            $query->where('country', $selectedCountry);
        }


        // Récupérer les données filtrées
        $viewData['farmerAccompaniements'] = $query->get();
        $viewData['accompaniements'] = Accompaniement::all();
        $viewData['countries'] = Country::orderBy('name', 'asc')->get();

        // Passer les filtres à la vue pour pré-remplir les champs
        $viewData['filterSeason'] = $filterSeason;
        $viewData['selectedYear'] = $selectedYear;
        $viewData['selectedTypeSupport'] = $selectedTypeSupport;
        $viewData['selectedCountry'] = $selectedCountry;

        return view('farmer_accompaniements.index')->with('viewData', $viewData);
    }


    /**
     * Afficher le formulaire de création d'un nouvel accompagnement.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add a Farmer Support';
        $viewData['farmers'] = Farmer::all();
        $viewData['accompaniements'] = Accompaniement::all();

        return view('farmer_accompaniements.create')->with('viewData', $viewData);
    }

    /**
     * Enregistrer un nouvel accompagnement dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|string|max:255',
            'season' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'site' => 'nullable|string|max:255',
            'territory' => 'nullable|string|max:255',
            'groupement' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'beneficiary_name' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'phone_number' => 'nullable|string|max:255',
            'gps_coordinates' => 'nullable|string|max:255',
            'crop_sown' => 'nullable|string|max:255',
            'variety' => 'nullable|string|max:255',
            'seed_quantity_received' => 'nullable|numeric',
            'fertilizer_type' => 'nullable|string|max:255',
            'fertilizer_quantity_base' => 'nullable|numeric',
            'fertilizer_quantity_surface' => 'nullable|numeric',
            'cultivated_area' => 'nullable|numeric',
            'training_sessions_received' => 'nullable|integer|min:0',
            'training_types_received' => 'nullable|string',
            'additional_support_received' => 'nullable|string',
            'quantity_produced' => 'nullable|numeric',
            'quantity_reimbursed' => 'nullable|numeric',
            'observations' => 'nullable|string',
            'accompaniement_id' => 'required',
        ]);

        $farmerAccompaniement = new FarmerAccompaniement();
        $farmerAccompaniement->year = $request->input('year');
        $farmerAccompaniement->season = $request->input('season');
        $farmerAccompaniement->country = $request->input('country');
        $farmerAccompaniement->province = $request->input('province');
        $farmerAccompaniement->site = $request->input('site');
        $farmerAccompaniement->territory = $request->input('territory');
        $farmerAccompaniement->groupement = $request->input('groupement');
        $farmerAccompaniement->village = $request->input('village');
        $farmerAccompaniement->beneficiary_name = $request->input('beneficiary_name');
        $farmerAccompaniement->gender = $request->input('gender');
        $farmerAccompaniement->age = $request->input('age');
        $farmerAccompaniement->phone_number = $request->input('phone_number');
        $farmerAccompaniement->gps_coordinates = $request->input('gps_coordinates');
        $farmerAccompaniement->crop_sown = $request->input('crop_sown');
        $farmerAccompaniement->variety = $request->input('variety');
        $farmerAccompaniement->seed_quantity_received = $request->input('seed_quantity_received');
        $farmerAccompaniement->fertilizer_type = $request->input('fertilizer_type');
        $farmerAccompaniement->fertilizer_quantity_base = $request->input('fertilizer_quantity_base');
        $farmerAccompaniement->fertilizer_quantity_surface = $request->input('fertilizer_quantity_surface');
        $farmerAccompaniement->cultivated_area = $request->input('cultivated_area');
        $farmerAccompaniement->training_sessions_received = $request->input('training_sessions_received');
        $farmerAccompaniement->training_types_received = $request->input('training_types_received');
        $farmerAccompaniement->additional_support_received = $request->input('additional_support_received');
        $farmerAccompaniement->quantity_produced = $request->input('quantity_produced');
        $farmerAccompaniement->quantity_reimbursed = $request->input('quantity_reimbursed');
        $farmerAccompaniement->observations = $request->input('observations');
        $farmerAccompaniement->accompaniement_id = $request->input('accompaniement_id');
        $farmerAccompaniement->save();

        return redirect()->route('farmer-accompaniements.index')->with('success', 'Farmer Support added successfully.');
    }

    /**
     * Afficher les détails d'un accompagnement spécifique.
     */
    public function show(FarmerAccompaniement $farmerAccompaniement)
    {
        $viewData = [];
        $viewData['title'] = 'Farmer Support Details';
        return view('farmer_accompaniements.show', compact('farmerAccompaniement'))->with('viewData', $viewData);
    }

    /**
     * Afficher le formulaire d'édition d'un accompagnement.
     */
    public function edit(FarmerAccompaniement $farmerAccompaniement)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Farmer Support';
        $viewData['farmers'] = Farmer::all();
        $viewData['accompaniements'] = Accompaniement::all();

        return view('farmer_accompaniements.edit', compact('farmerAccompaniement'))->with('viewData', $viewData);
    }

    /**
     * Mettre à jour un accompagnement existant.
     */
    public function update(Request $request, FarmerAccompaniement $farmerAccompaniement)
    {

        $request->validate([
            'year' => 'required|string|max:255',
            'season' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'site' => 'nullable|string|max:255',
            'territory' => 'nullable|string|max:255',
            'groupement' => 'nullable|string|max:255',
            'village' => 'nullable|string|max:255',
            'beneficiary_name' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'phone_number' => 'nullable|string|max:255',
            'gps_coordinates' => 'nullable|string|max:255',
            'crop_sown' => 'nullable|string|max:255',
            'variety' => 'nullable|string|max:255',
            'seed_quantity_received' => 'nullable|numeric',
            'fertilizer_type' => 'nullable|string|max:255',
            'fertilizer_quantity_base' => 'nullable|numeric',
            'fertilizer_quantity_surface' => 'nullable|numeric',
            'cultivated_area' => 'nullable|numeric',
            'training_sessions_received' => 'nullable|integer|min:0',
            'training_types_received' => 'nullable|string',
            'additional_support_received' => 'nullable|string',
            'quantity_produced' => 'nullable|numeric',
            'quantity_reimbursed' => 'nullable|numeric',
            'observations' => 'nullable|string',
            'accompaniement_id' => 'required',


        ]);


        $farmerAccompaniement->year = $request->input('year');
        $farmerAccompaniement->season = $request->input('season');
        $farmerAccompaniement->country = $request->input('country');
        $farmerAccompaniement->province = $request->input('province');
        $farmerAccompaniement->site = $request->input('site');
        $farmerAccompaniement->territory = $request->input('territory');
        $farmerAccompaniement->groupement = $request->input('groupement');
        $farmerAccompaniement->village = $request->input('village');
        $farmerAccompaniement->beneficiary_name = $request->input('beneficiary_name');
        $farmerAccompaniement->gender = $request->input('gender');
        $farmerAccompaniement->age = $request->input('age');
        $farmerAccompaniement->phone_number = $request->input('phone_number');
        $farmerAccompaniement->gps_coordinates = $request->input('gps_coordinates');
        $farmerAccompaniement->crop_sown = $request->input('crop_sown');
        $farmerAccompaniement->variety = $request->input('variety');
        $farmerAccompaniement->seed_quantity_received = $request->input('seed_quantity_received');
        $farmerAccompaniement->fertilizer_type = $request->input('fertilizer_type');
        $farmerAccompaniement->fertilizer_quantity_base = $request->input('fertilizer_quantity_base');
        $farmerAccompaniement->fertilizer_quantity_surface = $request->input('fertilizer_quantity_surface');
        $farmerAccompaniement->cultivated_area = $request->input('cultivated_area');
        $farmerAccompaniement->training_sessions_received = $request->input('training_sessions_received');
        $farmerAccompaniement->training_types_received = $request->input('training_types_received');
        $farmerAccompaniement->additional_support_received = $request->input('additional_support_received');
        $farmerAccompaniement->quantity_produced = $request->input('quantity_produced');
        $farmerAccompaniement->quantity_reimbursed = $request->input('quantity_reimbursed');
        $farmerAccompaniement->observations = $request->input('observations');
        $farmerAccompaniement->accompaniement_id = $request->input('accompaniement_id');

        $farmerAccompaniement->save();

        return redirect()->route('farmer-accompaniements.index')->with('success', 'Farmer Support updated successfully.');
    }

    /**
     * Supprimer un accompagnement.
     */
    public function destroy(FarmerAccompaniement $farmerAccompaniement)
    {
        $farmerAccompaniement->delete();
        return redirect()->route('farmer-accompaniements.index')->with('success', 'Farmer Support deleted successfully.');
    }

    /**
     * Exporter les données vers un fichier Excel.
     */
    public function exportToExcel(Request $request)
    {
        // Récupérer les paramètres de filtrage depuis la requête
        $filterSeason = $request->input('filter_type', 'A'); // Par défaut : journalier
        $selectedYear = $request->input('year');
        $selectedTypeSupport = $request->input(key: 'typeSupport');


        // Exporter les données filtrées
        return Excel::download(new FarmerAccompaniementExport(
            $filterSeason, $selectedYear, $selectedTypeSupport), 'farmer_accompaniements.xlsx');
    }

    /**
     * Générer un PDF avec les données.
     */
    public function generatePdf(Request $request)
    {
        $viewData = [];
        $viewData['title'] = 'List of Farmer Supports';

        // Récupérer les paramètres de filtrage depuis la requête
        $filterSeason = $request->input('filter_type', 'A'); // Par défaut : journalier
        $selectedYear = $request->input('year');
        $selectedTypeSupport = $request->input(key: 'typeSupport');


        // Construire la requête en fonction du type de filtre
        $query = FarmerAccompaniement::query();

        if ($selectedYear) {
            // Filtrer par jour
            $query->where('year', $selectedYear);
        }
        if ($filterSeason) {
            $query->where('season', $filterSeason);
        }
        if ($selectedTypeSupport) {
            $query->where('accompaniement_id', $selectedTypeSupport);
        }

        // Récupérer les données filtrées
        $viewData['farmerAccompaniements'] = $query->get();

        $pdf = Pdf::loadView('pdf.list_farmer_accompaniements', $viewData)->setPaper('a4', 'landscape');
        return $pdf->stream('farmer_accompaniements.pdf');
    }
}
