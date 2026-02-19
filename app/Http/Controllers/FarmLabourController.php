<?php

namespace App\Http\Controllers;

use App\Exports\FarmLaboursExport;
use App\Models\Farm;
use App\Models\FarmLabour;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FarmLabourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Farm labours';
        $viewData['farms_labours'] = FarmLabour::with('farm')->paginate(50); // Retrieve all farm labours with their associated farms

        return view('farm_labours.index')->with('viewData', $viewData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add a Farm labour';
        $viewData['farms'] = Farm::all();

        return view('farm_labours.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'farm_id' => 'required|string|exists:farms,id',
            'full_time_workers' => 'required|integer|min:0',
            'seasonal_workers' => 'required|integer|min:0',
            'part_time_workers' => 'required|integer|min:0'
        ]);

        FarmLabour::create($request->all());

        return redirect()->route('farmlabours.index')->with('success', 'Farm labour added successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(FarmLabour $farmLabour)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FarmLabour $farmlabour)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Farm labours';
        $viewData['farms'] = Farm::all(); // Retrieve all farm

        return view('farm_labours.edit', compact('farmlabour'))->with('viewData', $viewData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FarmLabour $farmlabour)
    {
        $request->validate([
            'farm_id' => 'required|string|exists:farms,id',
            'full_time_workers' => 'required|integer|min:0',
            'seasonal_workers' => 'required|integer|min:0',
            'part_time_workers' => 'required|integer|min:0'
        ]);

        $farmlabour->update($request->all());

        return redirect()->route('farmlabours.index')->with('success', 'Farm labour updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FarmLabour $farmlabour)
    {
        $farmlabour->delete();

        return redirect()->route('farmlabours.index')->with('success', 'Farm labour deleted successfully');
    }

    public function getfarmlaboursData()
    {
        return Excel::download(new FarmLaboursExport, 'farm_labours.xlsx');
    }

    public function print()
    {
        $viewData = [];
        $viewData['title'] = 'List of Farm labours';
        $viewData['farm_labours'] = FarmLabour::with('farm')->paginate(100);

        $pdf = Pdf::loadView('pdf.list_farm_labours', array('farm_labours' => $viewData['farm_labours']))
            ->setPaper('a4', 'portrait');

        return $pdf->stream();

    }
}
