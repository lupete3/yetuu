<?php

namespace App\Http\Controllers;

use App\Exports\FarmerExport;
use App\Models\Accompaniement;
use App\Models\Farmer;
use App\Models\Country;
use App\Models\Farm;
use App\Models\Province;
use App\Models\Territory;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class FarmerController extends Controller
{
    /**
     * Display a listing of the farmers.
     */
    public function index()
    {
        $viewData = [];
        $viewData['title'] = 'List of Farmers';
        $viewData['farmers'] = Farmer::with('country', 'province', 'territory', 'groupement')->paginate(50); // Use pagination for large datasets

        return view('farmers.index')->with('viewData', $viewData);
    }

    /**
     * Show the form for creating a new farmer.
     */
    public function create()
    {
        $viewData = [];
        $viewData['title'] = 'Add a Farmer';
        $viewData['countries'] = Country::all();
        $viewData['provinces'] = Province::all();
        $viewData['territories'] = Territory::all();
        $viewData['accompaniments'] = Accompaniement::all();

        return view('farmers.create')->with('viewData', $viewData);
    }

    /**
     * Store a newly created farmer in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'state_province_id' => 'required|exists:provinces,id',
            'territory_id' => 'required|exists:territories,id',
            'locality_id' => 'required|exists:groupements,id',
            'village' => 'nullable|string',
            'operational_site' => 'nullable|string',
            'number_of_family_members' => 'nullable|integer|min:1',
            'main_occupation' => 'nullable|string|max:255',
            'level_of_education' => 'nullable|string|max:255',
            'civil_status' => 'nullable|string|max:255',
            'accompaniment_id' => 'required|exists:accompaniements,id',
            'join_date' => 'nullable|date',
            'priority_crop' => 'required|string',
            'is_member_of_association' => 'nullable|boolean',
            'association_name' => 'nullable|string|max:255',
            'contact_number' => 'required|string|unique:farmers,contact_number',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'captured_photo' => 'nullable|string', // Champ pour la photo capturée en base64
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'doc_type' => 'required|string|max:255',

        ]);

        // Transformer en JSON si c'est un tableau
        if (is_array($request->input('asset_ownership'))) {
            $validatedData['asset_ownership'] = json_encode($request->input('asset_ownership'));
        }

        $farmer = new Farmer();
        $farmer->first_name = $request->input('first_name');
        $farmer->last_name = $request->input('last_name');
        $farmer->date_of_birth = $request->input('date_of_birth');
        $farmer->gender = $request->input('gender');
        $farmer->country_id = $request->input('country_id');
        $farmer->state_province_id = $request->input('state_province_id');
        $farmer->territory_id = $request->input('territory_id');
        $farmer->groupement_id = $request->input('locality_id');
        $farmer->village = $request->input('village');
        $farmer->operational_site = $request->input('operational_site');
        $farmer->number_of_family_members = $request->input('number_of_family_members');
        $farmer->main_occupation = $request->input('main_occupation');
        $farmer->level_of_education = $request->input('level_of_education');
        $farmer->civil_status = $request->input('civil_status');
        $farmer->accompaniement_id = $request->input('accompaniment_id');
        $farmer->join_date = $request->input('join_date');
        $farmer->priority_culture = $request->input('priority_crop');
        $farmer->status = $request->input('status');
        $farmer->is_member_of_association = $request->input('is_member_of_association');
        $farmer->association_name = $request->input('association_name');
        $farmer->contact_number = $request->input('contact_number');

        // Cas 1: Téléchargement de fichier
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
            $farmer->photo = $photoPath;
        }
        // Cas 2: Photo capturée avec la caméra (base64)
        elseif ($request->filled('captured_photo')) {
            $base64Image = $request->input('captured_photo');
            $image = str_replace('data:image/png;base64,', '', $base64Image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'photos/' . uniqid() . '.png';
            \Storage::disk('public')->put($imageName, base64_decode($image));
            $farmer->photo = $imageName;
        }

        $farmer->doc_type = $request->input('doc_type');

        $farmer->bank_name = $request->input('bank_name');
        $farmer->account_number = $request->input('account_number');

        $farmer->save();

        return redirect()->route('farmers.index')->with('success', 'Farmer added successfully');
    }


    /**
     * Display the specified farmer.
     */
    public function show(Farmer $farmer)
    {
        $viewData = [];
        $viewData['title'] = 'Farmer Details';
        return view('farmers.show', compact('farmer'))->with('viewData', $viewData);
    }

    /**
     * Show the form for editing the specified farmer.
     */
    public function edit(Farmer $farmer)
    {
        $viewData = [];
        $viewData['title'] = 'Edit Farmer';
        $viewData['countries'] = Country::all();
        $viewData['accompaniments'] = Accompaniement::all();

        return view('farmers.edit', compact('farmer'))->with('viewData', $viewData);
    }

    /**
     * Update the specified farmer in storage.
     */
    public function update(Request $request, Farmer $farmer)
    {

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'state_province_id' => 'required|exists:provinces,id',
            'territory_id' => 'required|exists:territories,id',
            'locality_id' => 'required|exists:groupements,id',
            'village' => 'nullable|string',
            'operational_site' => 'nullable|string',
            'number_of_family_members' => 'nullable|integer|min:1',
            'main_occupation' => 'nullable|string|max:255',
            'level_of_education' => 'nullable|string|max:255',
            'civil_status' => 'nullable|string|max:255',
            'accompaniment_id' => 'required|exists:accompaniements,id',
            'join_date' => 'nullable|date',
            'priority_crop' => 'required|string',
            'is_member_of_association' => 'nullable|boolean',
            'association_name' => 'nullable|string|max:255',
            //'contact_number' => 'required|string|unique:farmers,contact_number',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:20048',
            'captured_photo' => 'nullable|string', // Champ pour la photo capturée en base64
            'contact_number' => [
                'required',
                'string',
                Rule::unique('farmers', 'contact_number')->ignore($farmer->id),
            ],
            'bank_name' => 'nullable|string|max:255',
            'account_number' => 'nullable|string|max:255',
            'doc_type' => 'required|string|max:255',
        ]);

        $farmer->first_name = $request->input('first_name');
        $farmer->last_name = $request->input('last_name');
        $farmer->date_of_birth = $request->input('date_of_birth');
        $farmer->gender = $request->input('gender');
        $farmer->country_id = $request->input('country_id');
        $farmer->state_province_id = $request->input('state_province_id');
        $farmer->territory_id = $request->input('territory_id');
        $farmer->groupement_id = $request->input('locality_id');
        $farmer->village = $request->input('village');
        $farmer->operational_site = $request->input('operational_site');
        $farmer->number_of_family_members = $request->input('number_of_family_members');
        $farmer->main_occupation = $request->input('main_occupation');
        $farmer->level_of_education = $request->input('level_of_education');
        $farmer->civil_status = $request->input('civil_status');
        $farmer->accompaniement_id = $request->input('accompaniment_id');
        $farmer->join_date = $request->input('join_date');
        $farmer->priority_culture = $request->input('priority_crop');
        $farmer->status = $request->input('status');
        $farmer->is_member_of_association = $request->input('is_member_of_association');
        $farmer->association_name = $request->input('association_name');
        $farmer->contact_number = $request->input('contact_number');
        $farmer->doc_type = $request->input('doc_type');

        // Cas 1: Téléchargement de fichier
        if ($request->hasFile('photo')) {

            if ($farmer->photo) {
                if (file_exists('storage/app/public/' . $farmer->photo)) {
                    unlink('storage/app/public/' . $farmer->photo);
                }
            }

            $photoPath = $request->file('photo')->store('photos', 'public');
            $farmer->photo = $photoPath;
        }
        // Cas 2: Photo capturée avec la caméra (base64)
        elseif ($request->filled('captured_photo')) {
            $base64Image = $request->input('captured_photo');

            // Décodage de l'image base64
            $image = str_replace('data:image/png;base64,', '', $base64Image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'photos/' . uniqid() . '.png';

            // Enregistrement de l'image dans le disque 'public'
            \Storage::disk('public')->put($imageName, base64_decode($image));
            $farmer->photo = $imageName;
        }

        $farmer->bank_name = $request->input('bank_name');
        $farmer->account_number = $request->input('account_number');

        $farmer->save();

        return redirect()->route('farmers.index')->with('success', 'Farmer updated successfully');
    }

    /**
     * Remove the specified farmer from storage.
     */
    public function destroy(Farmer $farmer)
    {
        if ($farmer->photo) {
            if (file_exists('storage/app/public/' . $farmer->photo)) {
                unlink('storage/app/public/' . $farmer->photo);
            }
        }

        $farmer->delete();

        return redirect()->route('farmers.index')->with('success', 'Farmer deleted successfully');
    }

    public function getFarmer(Farmer $farmer)
    {
        if ($farmer) {
            $gpsData = Farm::where('farmer_id', '=', $farmer->id)->first();
            $gps = $gpsData->gps_location ?? 'N/A';

            return response()->json([
                'full_name' => $farmer->first_name . ' ' . $farmer->last_name,
                'country_name' => $farmer->country->name ?? 'N/A',
                'province_name' => $farmer->province->name ?? 'N/A',
                'territory_name' => $farmer->territory->name ?? 'N/A',
                'groupement_name' => $farmer->groupement->name ?? 'N/A',
                'village_name' => $farmer->village ?? 'N/A',
                'gender' => ucfirst($farmer->gender) ?? 'N/A',
                'phone' => $farmer->contact_number ?? 'N/A',
                'age' => Carbon::parse($farmer->date_of_birth)->age ?? 'N/A',
                'gps' => $gps,


            ]);
        }

        return response()->json(null); // Retourner null si l'agriculteur n'est pas trouvé
    }

    public function getFarmersData()
    {
        // Use cursor for memory efficiency with large datasets
        $farmers = Farmer::with(['country', 'province', 'territory', 'groupement'])->cursor();

        $data = [];
        foreach ($farmers as $farmer) {
            switch ($farmer->doc_type) {
                case ('passport'):
                    $doc = 'Passport';
                    break;
                case ('voting_card_id'):
                    $doc = 'Voting Card ID';
                    break;
                default:
                    $doc = 'Driving Lisence';
                    break;
            }
            $data[] = [
                'Farmer ID' => $farmer->farmer_id,
                'First Name' => $farmer->first_name,
                'Last Name' => $farmer->last_name,
                'Date of Birth' => $farmer->date_of_birth,
                'Gender' => $farmer->gender,
                'Country' => $farmer->country->name ?? 'N/A',
                'State/Province' => $farmer->province->name ?? 'N/A',
                'Territory' => $farmer->territory->name ?? 'N/A',
                'Groupement' => $farmer->groupement->name ?? 'N/A',
                'Village' => $farmer->village,
                'Operational Site' => $farmer->operational_site,
                'Family Members' => $farmer->number_of_family_members,
                'Main Occupation' => $farmer->main_occupation,
                'Level of Education' => $farmer->level_of_education,
                'Civil Status' => $farmer->civil_status,
                'Type Of Accompaniement' => $farmer->accompaniement->name ?? 'N/A',
                'Priotity Crop' => $farmer->priority_culture,
                'Member of Association' => $farmer->is_member_of_association ? 'Yes' : 'No',
                'Association Name' => $farmer->association_name,
                'Contact Number' => $farmer->contact_number,
                'Mobile Money Operator' => $farmer->bank_name,
                'Account Number' => $farmer->account_number,
                'Type Of Support' => $farmer->accompaniement->name ?? 'N/A',
                'Join Date' => $farmer->join_date ?? 'N/A',
                'Priority Crop' => $farmer->priority_culture ?? 'N/A',
                'Status' => $farmer->status == 1 ? 'Active' : 'Inactive',
                'Identity Proof' => $doc,
            ];
        }

        return Excel::download(new FarmerExport($data), 'farmers.xlsx');
    }

    public function print()
    {
        $viewData = [];
        $viewData['title'] = 'List of Farmers';
        $viewData['farmers'] = Farmer::with('country', 'province', 'territory')->paginate(100); // Paginate PDF print as well or limit it

        $pdf = Pdf::loadView('pdf.list_farmers', array('farmers' => $viewData['farmers']))
            ->setPaper('a4', 'landscape');

        return $pdf->stream();

    }
}
