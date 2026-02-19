<?php

namespace App\Http\Controllers;

use App\Exports\FieldExport;
use App\Models\Field;
use App\Models\Farmer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FieldController extends Controller
{
    /**
     * Display a listing of the fields.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Land Plots';
        $viewData['fields'] = Field::with('farmer')->paginate(50); // Retrieve all Leand Plots with their associated farmers

        foreach ($viewData['fields'] as $farm) {
            $gpsData = $farm->gps_location;
            // Assurez-vous que $gpsData n'est pas nul
            if ($gpsData) {
                // Retirer 'POLYGON((' et '))'
                $cleanedData = str_replace(['POLYGON((', '))'], '', $gpsData);

                // Diviser les coordonnées en fonction des virgules
                $points = explode(',', $cleanedData);

                $coordinates = [];
                foreach ($points as $point) {
                    $latLng = explode(' ', trim($point));
                    if (count($latLng) === 2) {
                        $coordinates[] = ['lat' => (float) $latLng[1], 'lng' => (float) $latLng[0]];
                    }
                }


            } else {
            }
        }

        return view('fields.index')->with('viewData', $viewData);

    }

    public function showAllMap()
    {
        $viewData = [];
        $viewData['title'] = 'List of Land Plots';

        $fields = Field::with('farmer')->get(); // Retrieve all fields with their associated farmers

        // Formatage des coordonnées pour Mapbox
        $fields->map(function ($field) {
            if ($field->gps_location) {
                // Nettoyez la donnée en enlevant "POLYGON((" et "))"
                $coordinatesString = str_replace(['POLYGON((', '))'], '', $field->gps_location);
                $coordinatesPairs = explode(',', $coordinatesString);

                $formattedCoordinates = [];
                foreach ($coordinatesPairs as $pair) {
                    list($lng, $lat) = explode(' ', trim($pair));
                    $formattedCoordinates[] = [(float) $lng, (float) $lat];
                }

                $field->formatted_coordinates = [$formattedCoordinates];
            } else {
                $field->formatted_coordinates = null;
            }
        });

        return view('fields.fields-map', ['fields' => $fields])->with('viewData', $viewData);

    }


    /**
     * Show the form for creating a new field.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add a Land Plot';
        $viewData['farmers'] = Farmer::all(); // Retrieve all farmers for the dropdown

        return view('fields.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created field in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // Décode les coordonnées
        $coordinates = json_decode($data['gps_location'], true);

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
                return redirect()->back()->withErrors(['gps_location' => '.']);
            }
        } else {
            return redirect()->back()->withErrors(['gps_location' => 'Invalid geolocations datas.']);
        }

        // Créer un nouvel objet Field
        $field = new Field();
        $field->field_name = $data['field_name'];
        $field->farmer_id = $data['farmer_id'];
        $field->total_area = $data['total_area'];
        $field->soil_type = $data['soil_type'];
        $field->irrigation_type = $data['irrigation_type'];
        $field->gps_location = DB::raw("ST_GeomFromText('$polygon')"); // Enregistrer comme Polygon
        $field->registration_date = $data['registration_date'];
        $field->save();

        return redirect()->route('fields.index')->with('success', 'Land Plot created successfully.');
    }

    /**
     * Display the specified field.
     */
    public function show(Field $field)
    {
        $viewData = [];
        $viewData['title'] = 'Land Plot Details';

        return view('fields.show', compact('field'))->with('viewData', $viewData);
    }

    /**
     * Show the form for editing the specified field.
     */
    public function edit(Field $field)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Land Plot';
        $viewData['farmers'] = Farmer::all(); // Retrieve all farmers for the dropdown

        return view('fields.edit', compact('field'))->with('viewData', $viewData);
    }

    /**
     * Update the specified field in storage.
     */
    public function update(Request $request, Field $field)
    {
        // Validate incoming request
        $data = $request->validate([
            'field_name' => 'required|string|max:255',
            'farmer_id' => 'required|exists:farmers,id',
            'total_area' => 'required|numeric',
            'soil_type' => 'required|string|max:255',
            'irrigation_type' => 'required|string|max:255',
            'gps_location' => 'nullable',
            'registration_date' => 'required|date',
        ]);

        // Décode les coordonnées
        $coordinates = json_decode($data['gps_location'], true);

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
                return redirect()->back()->withErrors(['gps_location' => '.']);
            }
        } else {
            return redirect()->back()->withErrors(['gps_location' => 'Invalid geolocation datas.']);
        }

        $field->field_name = $data['field_name'];
        $field->farmer_id = $data['farmer_id'];
        $field->total_area = $data['total_area'];
        $field->soil_type = $data['soil_type'];
        $field->irrigation_type = $data['irrigation_type'];
        $field->gps_location = DB::raw("ST_GeomFromText('$polygon')"); // Enregistrer comme Polygon
        $field->registration_date = $data['registration_date'];
        $field->save();

        return redirect()->route('fields.index')->with('success', 'Land Plot updated successfully.');
    }

    /**
     * Remove the specified field from storage.
     */
    public function destroy(Field $field)
    {

        $field->delete();

        return redirect()->route('fields.index')->with('success', 'Land Plot deleted successfully.');
    }

    public function getFieldsData()
    {
        return Excel::download(new FieldExport, 'fields.xlsx');
    }

    public function print()
    {
        $viewData = [];
        $viewData['title'] = 'List of Land Plots';
        $viewData['fields'] = Field::with('farmer')->get();

        $pdf = Pdf::loadView('pdf.list_fields', array('fields' => $viewData['fields']))
            ->setPaper('a4', 'portrait');

        return $pdf->stream();
    }
}
