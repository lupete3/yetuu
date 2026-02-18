<?php

namespace App\Http\Controllers;

use App\Exports\FarmsExport;
use App\Models\Farm;
use App\Models\Farmer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class FarmController extends Controller
{
    /**
     * Display a listing of the farms.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Farms';
        $viewData['farms'] = Farm::with('farmer')->get(); // Retrieve all farms with their associated farmers

        return view('farms.index')->with('viewData', $viewData);
    }

    public function showAllMap()
    {
        $viewData = [];
        $viewData['title'] = 'List of Farms';
        $farms = Farm::with('farmer')->get(); // Retrieve all farms with their associated farmers

        return view('farms.farms-map', compact('farms'))->with('viewData', $viewData);
    }

    /**
     * Show the form for creating a new farm.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add a Farm';
        $viewData['farmers'] = Farmer::all(); // Retrieve all farmers for the dropdown

        return view('farms.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created farm in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $data = $request->validate([
            'farmer_id' => 'required|exists:farmers,id',
            'farm_name' => 'required|string|max:255',
            'previous_cultivated_crop' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'proposed_planting_area' => 'required|numeric',
            'land_topography' => 'required|string|max:255',
            'total_land_holding' => 'required|numeric',
            'land_ownership' => 'required|in:own_by_family,own_by_individual,renting',
            'nearby' => 'nullable|string|max:255',
            'gps_location' => 'nullable|string|max:255',
            'photo' => 'nullable|image',
            'documents_upload.*' => 'nullable|file|mimes:pdf,docx,doc,jpeg,png,jpg',
            'registration_date' => 'required|date',
        ]);

        $documents = [];
        if ($request->hasFile('documents_upload')) {
            foreach ($request->file('documents_upload') as $file) {
                $path = $file->store('documents_upload', 'public'); // Stocke le fichier dans storage/app/public/documents
                $documents[] = [
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getClientMimeType(),
                ];
            }
        }

        $data['documents_upload'] = $documents;

        //Create the farm with auto-generated farm_id
        $farm = new Farm();
        $farm->farm_id = Str::uuid();
        $farm->farmer_id = $request->input('farmer_id');
        $farm->farm_name = $request->input('farm_name');
        $farm->previous_cultivated_crop = $request->input('previous_cultivated_crop');
        $farm->address = $request->input('address');
        $farm->proposed_planting_area = $request->input('proposed_planting_area');
        $farm->land_topography = $request->input('land_topography');
        $farm->total_land_holding = $request->input('total_land_holding');
        $farm->land_ownership = $request->input('land_ownership');
        $farm->nearby = $request->input('nearby');
        $farm->gps_location = $request->input('gps_location');

        if ($request->hasFile('photo')) {
            $farm->photo = $request->file('photo')->store('photos', 'public');
        }

        $farm->documents_upload = $data['documents_upload'];
        $farm->registration_date = $request->input('registration_date');

        $farm->save();

        return redirect()->route('farms.index')->with('success', 'Farm created successfully.');
    }

    /**
     * Display the specified farm.
     */
    public function show(Farm $farm)
    {
        $viewData = [];
        $viewData['title'] = 'Farm Details';

        return view('farms.show', compact('farm'))->with('viewData', $viewData);
    }

    /**
     * Show the form for editing the specified farm.
     */
    public function edit(Farm $farm)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Farm';
        $viewData['farmers'] = Farmer::all(); // Retrieve all farmers for the dropdown

        return view('farms.edit', compact('farm'))->with('viewData', $viewData);
    }

    /**
     * Update the specified farm in storage.
     */
    public function update(Request $request, Farm $farm)
    {
        // Validate incoming request
        $data = $request->validate([
            'farmer_id' => 'required|exists:farmers,id',
            'farm_name' => 'required|string|max:255',
            'previous_cultivated_crop' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'proposed_planting_area' => 'required|numeric',
            'land_topography' => 'required|string|max:255',
            'total_land_holding' => 'required|numeric',
            'land_ownership' => 'required|in:own_by_family,own_by_individual,renting',
            'nearby' => 'nullable|string|max:255',
            'gps_location' => 'nullable|string|max:255',
            'photo' => 'nullable|image',
            'documents_upload.*' => 'nullable|file|mimes:pdf,docx,doc,jpeg,png,jpg',
            'registration_date' => 'required|date',
        ]);

        // Récupère les documents existants
        $existingDocuments = $farm->documents_upload ? $farm->documents_upload : [];

        // Ajoute les nouveaux documents s'ils existent
        if ($request->hasFile('documents_upload')) {
            foreach ($request->file('documents_upload') as $file) {
                $path = $file->store('documents_upload', 'public');
                $existingDocuments[] = [
                    'filename' => $file->getClientOriginalName(),
                    'path' => $path,
                    'type' => $file->getClientMimeType(),
                ];
            }
        }

        // Met à jour la colonne documents_upload avec les documents existants fusionnés avec les nouveaux
        $data['documents_upload'] = $existingDocuments;

        // Update the farm
        $farm->farmer_id = $request->input('farmer_id');
        $farm->farm_name = $request->input('farm_name');
        $farm->previous_cultivated_crop = $request->input('previous_cultivated_crop');
        $farm->address = $request->input('address');
        $farm->proposed_planting_area = $request->input('proposed_planting_area');
        $farm->land_topography = $request->input('land_topography');
        $farm->total_land_holding = $request->input('total_land_holding');
        $farm->land_ownership = $request->input('land_ownership');
        $farm->nearby = $request->input('nearby');
        $farm->gps_location = $request->input('gps_location');

        if ($request->hasFile('photo')) {
            if (file_exists('storage/app/public/' . $farm->photo)) {
                unlink('storage/app/public/' . $farm->photo);
            }
            $photoPath = $request->file('photo')->store('photos', 'public');
            $farm->photo = $photoPath;
        }

        if ($data['documents_upload']) {
            $farm->documents_upload = $data['documents_upload'];
        }

        $farm->registration_date = $request->input('registration_date');

        $farm->save();

        return redirect()->route('farms.index')->with('success', 'Farm updated successfully.');
    }

    public function removeDocument(Request $request, $id)
    {
        $farm = Farm::findOrFail($id);

        // Vérifier si la photo existe dans les données
        $documents = json_decode($farm->documents_upload, true);
        $documentsToRemove = $request->input('document');

        if (($key = array_search($documentsToRemove, $documents)) !== false) {
            // Supprimer physiquement la photo
            Storage::delete('storage/app/public/' . $documentsToRemove);

            // Retirer la photo de l'array et mettre à jour les données
            unset($documents[$key]);
            $farm->photos = json_encode(array_values($documents));
            $farm->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Photo non trouvée.'], 404);

        return response()->json(['success' => false]);
    }


    /**
     * Remove the specified farm from storage.
     */
    public function destroy(Farm $farm)
    {
        if($farm->documents_upload){
            foreach ($farm->documents_upload as $document){
                \Storage::disk('public')->delete($document['path']);
            }
        }

        // Delete the farm
        $farm->delete();

        return redirect()->route('farms.index')->with('success', 'Farm deleted successfully.');
    }

    public function getFarmsData()
    {
        return Excel::download(new FarmsExport, 'farms.xlsx');
    }

    public function print()
    {
        $viewData = [];
        $viewData['title'] = 'List of Farms';
        $viewData['farms'] = Farm::with('farmer')->get();

        $pdf = Pdf::loadView('pdf.list_farms', array('farms' =>  $viewData['farms']))
        ->setPaper('a4', 'landscape');

        return $pdf->stream();

    }
}
