<?php

namespace App\Http\Controllers;

use App\Exports\CropManagementExport;
use App\Models\CropManagement;
use App\Models\Farmer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CropManagementController extends Controller
{
    /**
     * Display a listing of crop records.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'Crops List';
        $viewData['crops'] = CropManagement::with('farmer')->paginate(50);

        return view('crop_management.index')->with('viewData', $viewData);
    }

    /**
     * Show the form for creating a new crop record.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add Crop';
        $viewData['farmers'] = Farmer::all();

        return view('crop_management.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created crop record in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $data = $request->validate([
            'growing_season' => 'required|string|max:255',
            'farmer_id' => 'required|exists:farmers,id',
            'crop_type' => 'required|string|max:255',
            'variety_name' => 'nullable|string|max:255',
            'disease_resistance' => 'nullable|string|max:255',
            'growth_duration' => 'nullable|integer',
            'fertilizer_requirements' => 'nullable|string|max:255',
            'planting_date' => 'required|date',
            'harvest_date' => 'nullable|date|after_or_equal:planting_date',
            'growth_stage' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
        ]);

        $cropManagement = new CropManagement();

        $cropManagement->growing_season = $request->input('growing_season');
        $cropManagement->farmer_id = $request->input('farmer_id');
        $cropManagement->crop_type = $request->input('crop_type');
        $cropManagement->variety_name = $request->input('variety_name');
        $cropManagement->disease_resistance = $request->input('disease_resistance');
        $cropManagement->growth_duration = $request->input('growth_duration');
        $cropManagement->fertilizer_requirements = $request->input('fertilizer_requirements');
        $cropManagement->planting_date = $request->input('planting_date');
        $cropManagement->harvest_date = $request->input('harvest_date');
        $cropManagement->growth_stage = $request->input('growth_stage');

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('crops', 'public');
            $cropManagement->photo = $photoPath;
        }

        // Create the crop record
        CropManagement::create($data);

        return redirect()->route('crop-management.index')->with('success', 'Crop record created successfully.');
    }

    /**
     * Display the specified crop record.
     */
    public function show(CropManagement $cropManagement)
    {
        $viewData = [];
        $viewData['title'] = 'Crop Details';
        $crop = $cropManagement;

        return view('crop_management.show', compact('crop'))->with('viewData', $viewData);
    }

    /**
     * Show the form for editing the specified crop record.
     */
    public function edit(CropManagement $cropManagement)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Leand Plot';
        $viewData['farmers'] = Farmer::all();
        $crop = $cropManagement;

        return view('crop_management.edit', compact('crop'))->with('viewData', $viewData);
    }

    /**
     * Update the specified crop record in storage.
     */
    public function update(Request $request, CropManagement $cropManagement)
    {
        // Validate incoming request
        $request->validate([
            'growing_season' => 'required|string|max:255',
            'farmer_id' => 'required|exists:farmers,id',
            'crop_type' => 'required|string|max:255',
            'variety_name' => 'nullable|string|max:255',
            'disease_resistance' => 'nullable|string|max:255',
            'growth_duration' => 'nullable|integer',
            'fertilizer_requirements' => 'nullable|string|max:255',
            'planting_date' => 'required|date',
            'harvest_date' => 'nullable|date|after_or_equal:planting_date',
            'growth_stage' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
        ]);

        $cropManagement->growing_season = $request->input('growing_season');
        $cropManagement->farmer_id = $request->input('farmer_id');
        $cropManagement->crop_type = $request->input('crop_type');
        $cropManagement->variety_name = $request->input('variety_name');
        $cropManagement->disease_resistance = $request->input('disease_resistance');
        $cropManagement->growth_duration = $request->input('growth_duration');
        $cropManagement->fertilizer_requirements = $request->input('fertilizer_requirements');
        $cropManagement->planting_date = $request->input('planting_date');
        $cropManagement->harvest_date = $request->input('harvest_date');
        $cropManagement->growth_stage = $request->input('growth_stage');

        if ($request->hasFile('photo')) {

            if ($cropManagement->photo) {
                if (file_exists('storage/app/public/' . $cropManagement->photo)) {
                    unlink('storage/app/public/' . $cropManagement->photo);
                }
            }

            $photoPath = $request->file('photo')->store('crops', 'public');
            $cropManagement->photo = $photoPath;
        }

        // Update the crop record
        $cropManagement->save();

        return redirect()->route('crop-management.index')->with('success', 'Crop record updated successfully.');
    }

    /**
     * Remove the specified crop record from storage.
     */
    public function destroy(CropManagement $cropManagement)
    {
        if ($cropManagement->photo) {
            if (file_exists('storage/app/public/' . $cropManagement->photo)) {
                unlink('storage/app/public/' . $cropManagement->photo);
            }
        }

        $cropManagement->delete();

        return redirect()->route('crop-management.index')->with('success', 'Crop record deleted successfully.');
    }

    /**
     * Export crop data to an Excel file.
     */
    public function getCropData()
    {
        return Excel::download(new CropManagementExport, 'crop_management.xlsx');
    }

    /**
     * Generate a PDF of crop records.
     */
    public function print()
    {
        $viewData = [];
        $viewData['title'] = 'List of Farm Conversion';
        $viewData['crop_managements'] = CropManagement::with('farmer')->paginate(100);

        $pdf = Pdf::loadView('pdf.list_crop_management', [
            'crop_managements' => $viewData['crop_managements']
        ])->setPaper('a4', 'portrait');

        return $pdf->stream();
    }
}
