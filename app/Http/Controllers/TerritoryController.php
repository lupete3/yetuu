<?php

namespace App\Http\Controllers;

use App\Models\Province;
use App\Models\Territory;
use Illuminate\Http\Request;

class TerritoryController extends Controller
{
    /**
     * Display a listing of the territories.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Territories';
        $viewData['territories'] = Territory::with('province')->get(); // Retrieve all territories with their associated provinces

        return view('territories.index')->with('viewData', $viewData);
    }

    public function getTerritories($provinceId)
    {
        $territories = Territory::where('province_id', $provinceId)->get();
        return response()->json($territories);
    }

    /**
     * Show the form for creating a new territory.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add a Territory';
        $viewData['provinces'] = Province::all(); // Retrieve all provinces for the dropdown

        return view('territories.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created territory in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:territories,name,NULL,id,province_id,' . $request->input('province_id'),
            'province_id' => 'required|exists:provinces,id',
        ], [
            'name.required' => 'Territory name is required.',
            'province_id.required' => 'Province is required.',
        ]);

        // Create the territory
        $territory = new Territory();
        $territory->name = $request->input('name');
        $territory->province_id = $request->input('province_id');

        $territory->save();

        return redirect()->route('territories.index')->with('success', 'Territory created successfully.');
    }

    /**
     * Display the specified territory.
     */
    public function show(Territory $territory)
    {
        $viewData = [];
        $viewData['title'] = 'Territory Details';
        $viewData['territory'] = $territory->load('province'); // Load associated province data

        return view('territories.show')->with('viewData', $viewData);
    }

    /**
     * Show the form for editing the specified territory.
     */
    public function edit(Territory $territory)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Territory';
        $viewData['provinces'] = Province::all(); // Retrieve all provinces for the dropdown

        return view('territories.edit', compact('territory'))->with('viewData', $viewData);
    }

    /**
     * Update the specified territory in storage.
     */
    public function update(Request $request, Territory $territory)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:territories,name,' . $territory->id . ',id,province_id,' . $request->input('province_id'),
            'province_id' => 'required|exists:provinces,id',
        ], [
            'name.required' => 'Territory name is required.',
            'province_id.required' => 'Province is required.',
        ]);

        // Update the territory
        $territory->name = $request->input('name');
        $territory->province_id = $request->input('province_id');

        $territory->save();

        return redirect()->route('territories.index')->with('success', 'Territory updated successfully.');
    }

    /**
     * Remove the specified territory from storage.
     */
    public function destroy(Territory $territory)
    {
        // Delete the territory
        $territory->delete();

        return redirect()->route('territories.index')->with('success', 'Territory deleted successfully.');
    }
}
