<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the provinces.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Provinces';
        $viewData['provinces'] = Province::with('country')->get(); // Retrieve all provinces with their associated countries

        return view('provinces.index')->with('viewData', $viewData);
    }

    public function getProvinces($countryId)
    {
        
        $provinces = Province::where('country_id', $countryId)->get(['id', 'name']);
        return response()->json($provinces);
    }

    /**
     * Show the form for creating a new province.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add a Province';
        $viewData['countries'] = Country::all(); // Retrieve all countries for the dropdown

        return view('provinces.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created province in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:provinces,name,NULL,id,country_id,' . $request->input('country_id'),
            'country_id' => 'required|exists:countries,id',
        ], [
            'name.required' => 'Province name is required.',
            'country_id.required' => 'Country is required.',
        ]);

        // Create the province
        $province = new Province();
        $province->name = $request->input('name');
        $province->country_id = $request->input('country_id');

        $province->save();

        return redirect()->route('provinces.index')->with('success', 'Province created successfully.');
    }

    /**
     * Display the specified province.
     */
    public function show(Province $province)
    {
        $viewData = [];
        $viewData['title'] = 'Province Details';
        $viewData['province'] = $province->load('country'); // Load associated country data

        return view('provinces.show')->with('viewData', $viewData);
    }

    /**
     * Show the form for editing the specified province.
     */
    public function edit(Province $province)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Province';
        $viewData['countries'] = Country::all(); // Retrieve all countries for the dropdown

        return view('provinces.edit', compact('province'))->with('viewData', $viewData);
    }

    /**
     * Update the specified province in storage.
     */
    public function update(Request $request, Province $province)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:provinces,name,' . $province->id . ',id,country_id,' . $request->input('country_id'),
            'country_id' => 'required|exists:countries,id',
        ], [
            'name.required' => 'Province name is required.',
            'country_id.required' => 'Country is required.',
        ]);

        // Update the province
        $province->name = $request->input('name');
        $province->country_id = $request->input('country_id');

        $province->save();

        return redirect()->route('provinces.index')->with('success', 'Province updated successfully.');
    }

    /**
     * Remove the specified province from storage.
     */
    public function destroy(Province $province)
    {
        // Delete the province
        $province->delete();

        return redirect()->route('provinces.index')->with('success', 'Province deleted successfully.');
    }
}
