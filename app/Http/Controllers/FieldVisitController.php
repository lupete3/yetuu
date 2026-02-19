<?php

namespace App\Http\Controllers;

use App\Models\FieldVisit;
use App\Models\Field;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FieldVisitController extends Controller
{
    /**
     * Affiche la liste des visites de champs.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Land Visits';
        $viewData['field_visits'] = FieldVisit::with('field', 'user')->paginate(50); // Récupère les visites avec les agriculteurs associés

        return view('field_visits.index')->with('viewData', $viewData);
    }

    /**
     * Affiche le formulaire de création d'une nouvelle visite de champ.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add land visit';
        $viewData['fields'] = Field::with('farmer')->get(); // Pour sélectionner un agriculteur lors de la création
        $viewData['staffs'] = User::all();

        return view('field_visits.create')->with('viewData', $viewData);
    }

    /**
     * Enregistre une nouvelle visite de champ dans la base de données.
     */
    public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation pour les photos
            'gps_location' => 'nullable',
            'estimated_yield' => 'required',
        ]);

        // Gestion des photos
        $photos = [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('photos', 'public');
                $photos[] = $path;
            }
        }

        // Création de la visite de champ
        $fieldVisit = new FieldVisit();
        $fieldVisit->field_staff_id = $request->input('field_staff_id');
        $fieldVisit->field_id = $request->input('field_id');
        $fieldVisit->visit_date = $request->input('visit_date');
        $fieldVisit->notes = $request->input('notes');
        $fieldVisit->photos = $photos ? json_encode($photos) : null; // Stockage des chemins des photos en JSON
        $fieldVisit->gps_location = $request->input('gps_location');
        $fieldVisit->estimated_yield = $request->input('estimated_yield');

        $fieldVisit->save();

        return redirect()->route('field_visits.index')->with('success', 'Land saved successfully');
    }

    /**
     * Affiche les détails d'une visite de champ spécifique.
     */
    public function show(FieldVisit $fieldVisit)
    {
        $viewData = [];
        $viewData['title'] = 'Land visit detail';

        return view('field_visits.show', compact('fieldVisit'))->with('viewData', $viewData);
    }

    /**
     * Affiche le formulaire d'édition d'une visite de champ.
     */
    public function edit(FieldVisit $fieldVisit)
    {
        $viewData = [];
        $viewData['title'] = 'Edit land field';
        $viewData['fields'] = Field::with('farmer')->get(); // Pour sélectionner un agriculteur lors de la création
        $viewData['staffs'] = User::all(); // Pour sélectionner un agriculteur lors de la création


        return view('field_visits.edit', compact('fieldVisit'))->with('viewData', $viewData);
    }

    /**
     * Met à jour les informations d'une visite de champ dans la base de données.
     */
    public function update(Request $request, FieldVisit $fieldVisit)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validation pour les photos
            'gps_location' => 'nullable',
            'estimated_yield' => 'required',
        ]);

        // Gestion des nouvelles photos
        $photos = json_decode($fieldVisit->photos, true) ?? [];
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('photos', 'public');
                $photos[] = $path;
            }
        }

        // Mise à jour de la visite de champ
        $fieldVisit->field_staff_id = $request->input('field_staff_id');
        $fieldVisit->field_id = $request->input('field_id');
        $fieldVisit->visit_date = $request->input('visit_date');
        $fieldVisit->notes = $request->input('notes');
        $fieldVisit->photos = $photos ? json_encode($photos) : null; // Stockage des chemins des photos en JSON
        $fieldVisit->gps_location = $request->input('gps_location');
        $fieldVisit->estimated_yield = $request->input('estimated_yield');

        $fieldVisit->save();

        return redirect()->route('field_visits.index')->with('success', 'Land visit updated successfully');
    }

    /**
     * Supprime une visite de champ de la base de données.
     */
    public function destroy(FieldVisit $fieldVisit)
    {
        // Suppression des photos du stockage
        if ($fieldVisit->photos) {
            foreach (json_decode($fieldVisit->photos, true) as $photo) {
                Storage::disk('public')->delete($photo);
            }
        }

        $fieldVisit->delete();

        return redirect()->route('field_visits.index')->with('success', 'Land deleted successfully');
    }

    public function removePhoto(Request $request, $id)
    {
        $fieldVisit = FieldVisit::findOrFail($id);

        // Vérifier si la photo existe dans les données
        $photos = json_decode($fieldVisit->photos, true);
        $photoToRemove = $request->input('photo');

        if (($key = array_search($photoToRemove, $photos)) !== false) {
            // Supprimer physiquement la photo
            Storage::delete('storage/app/public/' . $photoToRemove);

            // Retirer la photo de l'array et mettre à jour les données
            unset($photos[$key]);
            $fieldVisit->photos = json_encode(array_values($photos));
            $fieldVisit->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Picture not found.'], 404);
    }

}
