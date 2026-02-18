<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the countries.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Countries';
        $viewData['countries'] = Country::all(); // Retrieve all countries

        return view('countries.index')->with('viewData', $viewData);
    }

    /**
     * Show the form for creating a new country.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add a Country';

        return view('countries.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created country in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:countries,name',
            'code' => 'required|string|max:3|unique:countries,code', // Assuming ISO 3166-1 alpha-3 code
        ], [
            'name.required' => 'Country name is required.',
            'code.required' => 'Country code is required.',
        ]);

        // Create the country
        $country = new Country();
        $country->name = $request->input('name');
        $country->code = strtoupper($request->input('code')); // Ensure code is uppercase

        $country->save();

        return redirect()->route('countries.index')->with('success', 'Country created successfully.');
    }

    /**
     * Display the specified country.
     */
    public function show(Country $country)
    {
        $viewData = [];
        $viewData['title'] = 'Country Details';
        $viewData['country'] = $country;

        return view('countries.show')->with('viewData', $viewData);
    }

    /**
     * Show the form for editing the specified country.
     */
    public function edit(Country $country)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Country';

        return view('countries.edit', compact('country'))->with('viewData', $viewData);
    }

    /**
     * Update the specified country in storage.
     */
    public function update(Request $request, Country $country)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:countries,name,' . $country->id,
            'code' => 'required|string|max:3|unique:countries,code,' . $country->id, // Assuming ISO 3166-1 alpha-3 code
        ], [
            'name.required' => 'Country name is required.',
            'code.required' => 'Country code is required.',
        ]);

        // Update the country
        $country->name = $request->input('name');
        $country->code = strtoupper($request->input('code')); // Ensure code is uppercase

        $country->save();

        return redirect()->route('countries.index')->with('success', 'Country updated successfully.');
    }

    /**
     * Remove the specified country from storage.
     */
    public function destroy(Country $country)
    {
        // Delete the country
        $country->delete();

        return redirect()->route('countries.index')->with('success', 'Country deleted successfully.');
    }
}
