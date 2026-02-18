<?php

namespace App\Http\Controllers;

use App\Exports\FarmConversionsExport;
use App\Models\Farm;
use App\Models\FarmConversion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FarmConversionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Farm conversion information';
        $viewData['farms_conversions'] = FarmConversion::with('farm')->get(); // Retrieve all farm conversion info with their associated farms

        return view('farm_conversions.index')->with('viewData', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add a Farm conversion information';
        $viewData['farms'] = Farm::all();

        return view('farm_conversions.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'farm_id' => 'required|exists:farms,id',
            'last_date_chemical_applied' => 'nullable|date',
            'estimated_yield' => 'nullable|numeric|min:0',
            'conventional_lands' => 'nullable|string',
            'conventional_crops' => 'nullable|string',
            'inspector_name' => 'nullable|string|max:255',
            'qualified_inspector' => 'nullable|boolean',
            'date_of_inspection' => 'nullable|date',
        ]);

        // Création d'un enregistrement avec les données validées
        FarmConversion::create($request->all());

        return redirect()->route('farmconversions.index')->with('success', 'Farm labour added successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(FarmConversion $farmConversion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FarmConversion $farmconversion)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Farm conversion information';
        $viewData['farms'] = Farm::all(); // Retrieve all farm

        return view('farm_conversions.edit', compact('farmconversion'))->with('viewData', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FarmConversion $farmconversion)
    {
        
        $request->validate([
            'farm_id' => 'required|exists:farms,id',
            'last_date_chemical_applied' => 'nullable|date',
            'estimated_yield' => 'nullable|numeric|min:0',
            'conventional_lands' => 'nullable|string',
            'conventional_crops' => 'nullable|string',
            'inspector_name' => 'nullable|string|max:255',
            'qualified_inspector' => 'nullable|boolean',
            'date_of_inspection' => 'nullable|date',
        ]);

        // Création d'un enregistrement avec les données validées
        $farmconversion->update($request->all());

        return redirect()->route('farmconversions.index')->with('success', 'Farm conversion information updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FarmConversion $farmconversion)
    {
        $farmconversion->delete();
    }

    public function getfarmconversionData()
    {
        return Excel::download(new FarmConversionsExport, 'farm_conversions.xlsx');
    }

    public function print()
    {
        $viewData = [];
        $viewData['title'] = 'List of Farm conversion';
        $viewData['farm_conversions'] = FarmConversion::with('farm')->get();

        $pdf = Pdf::loadView('pdf.list_farm_conversions', array('farm_conversions' =>  $viewData['farm_conversions']))
        ->setPaper('a4', 'portrait');

        return $pdf->stream();

    }
}
