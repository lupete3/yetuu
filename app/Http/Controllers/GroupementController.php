<?php

namespace App\Http\Controllers;

use App\Models\Groupement;
use App\Models\Province;
use App\Models\Territory;
use Illuminate\Http\Request;

class GroupementController extends Controller
{
    /**
     * Display a listing of the groupements.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Locality';
        $viewData['territories'] = Territory::with('province')->get(); // Retrieve all territories with their associated provinces
        $viewData['localities'] = Groupement::with('territory')->get(); // Retrieve all localities with their associated provinces

        return view('groupements.index')->with('viewData', $viewData);
    }

    public function getLocalities($territoryId)
    {
        $localities = Groupement::where('territory_id', $territoryId)->get();
        return response()->json($localities);
    }

    /**
     * Show the form for creating a new territory.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add a Locality';
        $viewData['provinces'] = Province::all(); // Retrieve all provinces for the dropdown
        $viewData['territories'] = Territory::all(); // Retrieve all localities for the dropdown

        return view('groupements.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created territory in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:groupements,name,NULL,id,territory_id,' . $request->input('territory_id'),
            'territory_id' => 'required|exists:territories,id',
        ], [
            'name.required' => 'Territory name is required.',
            'territory_id.required' => 'Locality is required.',
        ]);

        // Create the territory
        $locality = new Groupement();
        $locality->name = $request->input('name');
        $locality->territory_id = $request->input('territory_id');

        $locality->save();

        return redirect()->route('localities.index')->with('success', 'Locality created successfully.');
    }

    /**
     * Display the specified territory.
     */
    public function show(Groupement $groupement)
    {
        $viewData = [];
        $viewData['title'] = 'Locality Details';
        $viewData['localities'] = $groupement->load('territory'); // Load associated locality data

        return view('groupements.show')->with('viewData', $viewData);
    }

    /**
     * Show the form for editing the specified territory.
     */
    public function edit(Groupement $locality)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Locality';
        $viewData['provinces'] = Province::all(); // Retrieve all provinces for the dropdown
        $viewData['territories'] = Territory::all(); // Retrieve all territories for the dropdown

        return view('groupements.edit', compact('locality'))->with('viewData', $viewData);
    }

    /**
     * Update the specified territory in storage.
     */
    public function update(Request $request, Groupement $locality)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:groupements,name,' . $locality->id . ',id,territory_id,' . $request->input('territory_id'),
            'territory_id' => 'required|exists:territories,id',
        ], [
            'name.required' => 'Locality name is required.',
            'territory_id.required' => 'Territory is required.',
        ]);

        // Update the territory
        $locality->name = $request->input('name');
        $locality->territory_id = $request->input('territory_id');

        $locality->save();

        return redirect()->route('localities.index')->with('success', 'Locality updated successfully.');
    }

    /**
     * Remove the specified territory from storage.
     */
    public function destroy(Groupement $groupement)
    {
        // Delete the gr$groupement
        $groupement->delete();

        return redirect()->route('groupements.index')->with('success', 'Locality deleted successfully.');
    }
}
