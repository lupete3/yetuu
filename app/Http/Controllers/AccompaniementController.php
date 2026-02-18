<?php

namespace App\Http\Controllers;

use App\Models\Accompaniement;
use App\Models\Country;
use Illuminate\Http\Request;

class AccompaniementController extends Controller
{
    /**
     * Display a listing of the countries.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Type Of Support';
        $viewData['accompaniements'] = Accompaniement::all(); // Retrieve all countries

        return view('accompaniements.index')->with('viewData', $viewData);
    }

    /**
     * Show the form for creating a new country.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add a Type Of Support';

        return view('accompaniements.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created country in storage.
     */
    public function store(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:accompaniements,name',
        ], [
            'name.required' => 'Type Of Support name is required.',
        ]);

        // Create the country
        $accompaniement = new Accompaniement();
        $accompaniement->name = $request->input('name');

        $accompaniement->save();

        return redirect()->route('accompaniements.index')->with('success', 'Type Of Support created successfully.');
    }

    /**
     * Display the specified country.
     */
    public function show(Accompaniement $accompaniement)
    {
        $viewData = [];
        $viewData['title'] = 'Type Of Support Details';
        $viewData['accompaniement'] = $accompaniement;

        return view('accompaniements.show')->with('viewData', $viewData);
    }

    /**
     * Show the form for editing the specified country.
     */
    public function edit(Accompaniement $accompaniement)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Type Of Support';

        return view('accompaniements.edit', compact('accompaniement'))->with('viewData', $viewData);
    }

    /**
     * Update the specified country in storage.
     */
    public function update(Request $request, Accompaniement $accompaniement)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string|max:255|unique:accompaniements,name,' . $accompaniement->id,
        ], [
            'name.required' => 'Type Of Support name is required.',
        ]);

        // Update the country
        $accompaniement->name = $request->input('name');

        $accompaniement->save();

        return redirect()->route('accompaniements.index')->with('success', 'Type Of Support updated successfully.');
    }

    /**
     * Remove the specified country from storage.
     */
    public function destroy(Accompaniement $accompaniement)
    {
        // Delete the country
        $accompaniement->delete();

        return redirect()->route('accompaniements.index')->with('success', 'Type Of Support deleted successfully.');
    }
}
