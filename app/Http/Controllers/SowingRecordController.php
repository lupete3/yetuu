<?php

namespace App\Http\Controllers;

use App\Models\SowingRecord;
use App\Models\Field;
use App\Models\CropManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SowingRecordController extends Controller
{
    /**
     * Display a listing of the sowing records.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Sowing Records';
        $viewData['sowing_records'] = SowingRecord::with('field', 'crop')->paginate(50); // Retrieve sowing records with associated fields and crops

        return view('sowing_records.index')->with('viewData', $viewData);
    }

    /**
     * Show the form for creating a new sowing record.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add Sowing Record';
        $viewData['fields'] = Field::all(); // To select a field when creating a sowing record
        $viewData['crops'] = CropManagement::all(); // To select a crop when creating a sowing record

        return view('sowing_records.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created sowing record in the database.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'crop_id' => 'required|exists:crop_management,id',
            'sowing_date' => 'required|date',
            'area_sown' => 'required|numeric',
            'gps_coordinates' => 'nullable',
            'geo_map_url' => 'nullable',
        ]);

        // Décode les coordonnées
        $coordinates = json_decode($data['gps_coordinates'], true);

        // Vérifiez si la décodage est correct et si chaque élément est bien un tableau
        if (is_array($coordinates) && count($coordinates) > 0 && is_array($coordinates[0])) {
            try {
                $formattedCoordinates = array_map(function ($coord) {
                    // Assurez-vous que chaque coordonnée est bien un tableau avec deux éléments (latitude et longitude)
                    if (is_array($coord) && count($coord) == 2) {
                        return implode(' ', $coord);
                    } else {
                        throw new \Exception("Invalid coordinate format");
                    }
                }, $coordinates);

                $polygon = 'POLYGON((' . implode(',', $formattedCoordinates) . '))';

                // Enregistrez ou traitez $polygon ici
                // ...
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(['gps_coordinates' => '.']);
            }
        } else {
            return redirect()->back()->withErrors(['gps_coordinates' => 'Localisations data are invalids.']);
        }

        // Create a new sowing record
        $sowingRecord = new SowingRecord();
        $sowingRecord->field_id = $data['field_id'];
        $sowingRecord->crop_id = $data['crop_id'];
        $sowingRecord->sowing_date = $data['sowing_date'];
        $sowingRecord->area_sown = $data['area_sown'];
        $sowingRecord->gps_coordinates = DB::raw("ST_GeomFromText('$polygon')"); // Enregistrer comme Polygon
        $sowingRecord->geo_map_url = null;

        $sowingRecord->save();

        return redirect()->route('sowing-records.index')->with('success', 'Sowing record created successfully');
    }

    /**
     * Display the details of a specific sowing record.
     */
    public function show(SowingRecord $sowingRecord)
    {
        $viewData = [];
        $viewData['title'] = 'Sowing Record Detail';

        return view('sowing_records.show', compact('sowingRecord'))->with('viewData', $viewData);
    }

    /**
     * Show the form for editing a sowing record.
     */
    public function edit(SowingRecord $sowingRecord)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Sowing Record';
        $viewData['fields'] = Field::all(); // To select a field when editing
        $viewData['crops'] = CropManagement::all(); // To select a crop when editing

        return view('sowing_records.edit', compact('sowingRecord'))->with('viewData', $viewData);
    }

    /**
     * Update the specified sowing record in the database.
     */
    public function update(Request $request, SowingRecord $sowingRecord)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'crop_id' => 'required|exists:crop_management,id',
            'sowing_date' => 'required|date',
            'area_sown' => 'required|numeric',
            'gps_coordinates' => 'nullable|array',
            'geo_map_url' => 'nullable|url',
        ]);

        // Update the sowing record
        $sowingRecord->field_id = $request->input('field_id');
        $sowingRecord->crop_id = $request->input('crop_id');
        $sowingRecord->sowing_date = $request->input('sowing_date');
        $sowingRecord->area_sown = $request->input('area_sown');
        $sowingRecord->gps_coordinates = $request->input('gps_coordinates');
        $sowingRecord->geo_map_url = $request->input('geo_map_url');

        $sowingRecord->save();

        return redirect()->route('sowing-records.index')->with('success', 'Sowing record updated successfully');
    }

    /**
     * Remove a sowing record from the database.
     */
    public function destroy(SowingRecord $sowingRecord)
    {
        $sowingRecord->delete();

        return redirect()->route('sowing-records.index')->with('success', 'Sowing record deleted successfully');
    }
}
