@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('farmer-accompaniements.index') }}">Farmer Support</a></div>
                    <div class="breadcrumb-item">{{ $viewData['title'] }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissible" id="msg" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h6>{{ Session::get('success') }}</h6>
                            </div>
                        @endif

                        <div class="card">
                            <form method="post" action="{{ route('farmer-accompaniements.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4>{{ $viewData['title'] }}</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('farmer-accompaniements.index') }}" class="btn btn-icon icon-left btn-success">
                                            <i class="fas fa-list-alt"></i> View
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body row">

                                    <div class="form-group col-md-3">
                                        <label>Select Type Of Support/Activity</label>
                                        <select name="accompaniement_id" class="form-control form-control-sm select2" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Type Of Support/Activity</option>
                                            @foreach($viewData['accompaniements'] as $accompaniement)
                                                <option value="{{ $accompaniement->id }}">
                                                    {{ $accompaniement->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Select Year</label>
                                        <select name="year" class="form-control form-control-sm select2" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Year</option>
                                            @for ($year = now()->year; $year >= now()->year - 20; $year--)
                                                <option value="{{ $year }}">
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Select Season</label>
                                        <select name="season" id="season" class="form-control form-control-sm select2" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Season</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                        </select>
                                        @error('farmer_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Select Farmer</label>
                                        <select name="farmer_id" id="farmer" class="form-control form-control-sm select2" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Farmer</option>
                                            @foreach ($viewData['farmers'] as $farmer)
                                                <option value="{{ $farmer->id }}">{{ $farmer->first_name }} {{ $farmer->last_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('farmer_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Beneficiary Name -->
                                    <div class="form-group col-md-3">
                                        <label>Beneficiary Name</label>
                                        <input type="text" class="form-control" name="beneficiary_name" id="beneficiary_name" value="{{ old('beneficiary_name') }}" placeholder="Full Name of the Beneficiary">
                                        @error('beneficiary_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Country -->
                                    <div class="form-group col-md-3">
                                        <label>Country</label>
                                        <input type="text" class="form-control" name="country" id="country" value="{{ old('country') }}" placeholder="Country">
                                        @error('country')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Province -->
                                    <div class="form-group col-md-3">
                                        <label>Province</label>
                                        <input type="text" class="form-control" name="province" id="province" value="{{ old('province') }}" placeholder="Province/State">
                                        @error('province')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Territory -->
                                    <div class="form-group col-md-3">
                                        <label>Territory</label>
                                        <input type="text" class="form-control" name="territory" id="territory" value="{{ old('territory') }}" placeholder="Territory">
                                        @error('territory')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <!-- Groupement -->
                                    <div class="form-group col-md-3">
                                        <label>Groupement</label>
                                        <input type="text" class="form-control" name="groupement" id="groupement" value="{{ old('groupement') }}" placeholder="Group Name">
                                        @error('groupement')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Village -->
                                    <div class="form-group col-md-3">
                                        <label>Village</label>
                                        <input type="text" class="form-control" name="village" id="village" value="{{ old('village') }}" placeholder="Village Name">
                                        @error('village')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Gender -->
                                    <div class="form-group col-md-3">
                                        <label>Gender</label>
                                        <input type="text" class="form-control" name="gender" id="gender" value="{{ old('gender') }}" placeholder="Gender">
                                        @error('gender')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Age -->
                                    <div class="form-group col-md-3">
                                        <label>Age</label>
                                        <input type="number" class="form-control" name="age" id="age" value="{{ old('age') }}" placeholder="Age">
                                        @error('age')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="form-group col-md-3">
                                        <label>Phone Number</label>
                                        <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" placeholder="Contact Number">
                                        @error('phone_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Site -->
                                    <div class="form-group col-md-3">
                                        <label>Site</label>
                                        <input type="text" class="form-control" name="site" value="{{ old('site') }}" placeholder="Operational Site">
                                        @error('site')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- GPS Coordinates -->
                                    <div class="form-group col-md-3">
                                        <label>GPS Coordinates</label>
                                        <input type="text" class="form-control" name="gps_coordinates" id="gps_coordinates" value="{{ old('gps_coordinates') }}" placeholder="Latitude, Longitude">
                                        @error('gps_coordinates')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Crop Sown -->
                                    <div class="form-group col-md-3">
                                        <label>Crop Sown</label>
                                        <input type="text" class="form-control" name="crop_sown" value="{{ old('crop_sown') }}" placeholder="Type of Crop">
                                        @error('crop_sown')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Variety -->
                                    <div class="form-group col-md-3">
                                        <label>Variety</label>
                                        <input type="text" class="form-control" name="variety" value="{{ old('variety') }}" placeholder="Crop Variety">
                                        @error('variety')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Seed Quantity Received (Kg) -->
                                    <div class="form-group col-md-3">
                                        <label>Seed Quantity Received (Kg)</label>
                                        <input type="number" step="0.01" class="form-control" name="seed_quantity_received" value="{{ old('seed_quantity_received') }}" placeholder="Quantity in Kg">
                                        @error('seed_quantity_received')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Fertilizer Type -->
                                    <div class="form-group col-md-3">
                                        <label>Fertilizer Type</label>
                                        <input type="text" class="form-control" name="fertilizer_type" value="{{ old('fertilizer_type') }}" placeholder="Type of Fertilizer">
                                        @error('fertilizer_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Basal Fertilizer (Kg) -->
                                    <div class="form-group col-md-3">
                                        <label>Quantity Basal Fertilizer Received (Kg)</label>
                                        <input type="number" step="0.01" class="form-control" name="fertilizer_quantity_base" value="{{ old('fertilizer_quantity_base') }}" placeholder="Quantity in Kg">
                                        @error('fertilizer_quantity_base')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Top-dressing (Kg) -->
                                    <div class="form-group col-md-3">
                                        <label>Quantity Top-dressing Fertilizer Received (Kg)</label>
                                        <input type="number" step="0.01" class="form-control" name="fertilizer_quantity_surface" value="{{ old('fertilizer_quantity_surface') }}" placeholder="Quantity in Kg">
                                        @error('fertilizer_quantity_surface')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Superficial Area Cultivated -->
                                    <div class="form-group col-md-3">
                                        <label>Superficial Area Cultivated</label>
                                        <input type="number" step="0.01" class="form-control" name="cultivated_area" value="{{ old('cultivated_area') }}" placeholder="Area in Square Meters">
                                        @error('cultivated_area')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Training Sessions Received -->
                                    <div class="form-group col-md-3">
                                        <label>Training Sessions Received</label>
                                        <input type="number" class="form-control" name="training_sessions_received" value="{{ old('training_sessions_received') }}" placeholder="Number of Sessions">
                                        @error('training_sessions_received')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Types of Training Received -->
                                    <div class="form-group col-md-3">
                                        <label>Types of Training Received</label>
                                        <textarea class="form-control" name="training_types_received" rows="3">{{ old('training_types_received') }}</textarea>
                                        @error('training_types_received')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Additional Support Received -->
                                    <div class="form-group col-md-3">
                                        <label>Additional Support Received</label>
                                        <textarea class="form-control" name="additional_support_received" rows="3">{{ old('additional_support_received') }}</textarea>
                                        @error('additional_support_received')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Quantity Produced (Kg) -->
                                    <div class="form-group col-md-3">
                                        <label>Quantity Produced (Kg)</label>
                                        <input type="number" step="0.01" class="form-control" name="quantity_produced" value="{{ old('quantity_produced') }}" placeholder="Quantity in Kg">
                                        @error('quantity_produced')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Quantity Reimbursed (Kg) -->
                                    <div class="form-group col-md-3">
                                        <label>Quantity Reimbursed (Kg)</label>
                                        <input type="number" step="0.01" class="form-control" name="quantity_reimbursed" value="{{ old('quantity_reimbursed') }}" placeholder="Quantity in Kg">
                                        @error('quantity_reimbursed')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Observations -->
                                    <div class="form-group col-md-3">
                                        <label>Observations</label>
                                        <textarea class="form-control" name="observations" rows="3">{{ old('observations') }}</textarea>
                                        @error('observations')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="form-group col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

<script src="{{asset('assets/backend/modules/jquery.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('#farmer').change(function() {
            var farmerID = $(this).val();
            console.log('Farmer selected: ' + farmerID);

            if (farmerID) {
                $.ajax({
                    url: '{{ route("getFarmerById", ":farmer") }}'.replace(':farmer', farmerID),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data); // Vérifiez la réponse dans la console

                        // Remplir le champ "Beneficiary Full Name"
                        if (data && data.full_name) {
                            $('#beneficiary_name').val(data.full_name);
                        } else {
                            $('#beneficiary_name').val(''); // Effacer le champ si aucune donnée n'est trouvée
                        }

                        // Remplir le champ "Country"
                        if (data && data.country_name) {
                            $('#country').val(data.country_name);
                        } else {
                            $('#country').val(''); // Effacer le champ si aucune donnée n'est trouvée
                        }


                        // Remplir le champ "Province"
                        if (data && data.province_name) {
                            $('#province').val(data.province_name);
                        } else {
                            $('#province').val(''); // Effacer le champ si aucune donnée n'est trouvée
                        }

                        // Remplir le champ "Country"
                        if (data && data.territory_name) {
                            $('#territory').val(data.territory_name);
                        } else {
                            $('#territory').val(''); // Effacer le champ si aucune donnée n'est trouvée
                        }

                        // Remplir le champ "Country"
                        if (data && data.groupement_name) {
                            $('#groupement').val(data.groupement_name);
                        } else {
                            $('#groupement').val(''); // Effacer le champ si aucune donnée n'est trouvée
                        }

                        // Remplir le champ "Country"
                        if (data && data.village_name) {
                            $('#village').val(data.village_name);
                        } else {
                            $('#village').val(''); // Effacer le champ si aucune donnée n'est trouvée
                        }

                        // Remplir le champ "Gender"
                        if (data && data.gender) {
                            $('#gender').val(data.gender);
                        } else {
                            $('#gender').val(''); // Effacer le champ si aucune donnée n'est trouvée
                        }

                        // Remplir le champ "Phone"
                        if (data && data.phone) {
                            $('#phone_number').val(data.phone);
                        } else {
                            $('#phone_number').val(''); // Effacer le champ si aucune donnée n'est trouvée
                        }

                        // Remplir le champ "Age"
                        if (data && data.age) {
                            $('#age').val(data.age);
                            console.log(data.age)
                        } else {
                            $('#age').val(''); // Effacer le champ si aucune donnée n'est trouvée
                        }

                        // Remplir le champ "GPS"
                        if (data && data.gps) {
                            $('#gps_coordinates').val(data.gps);
                            console.log(data.gps)
                        } else {
                            $('#gps_coordinates').val(''); // Effacer le champ si aucune donnée n'est trouvée
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching farmer details:', error);
                        alert('An error occurred while fetching farmer details.');
                    }
                });
            } else {
                // Effacer le champ si aucun agriculteur n'est sélectionné
                $('#beneficiary_name').val('');
            }
        });

        // Quand la province est sélectionnée, charger les territoires
        $('#state_province').change(function() {
            var provinceID = $(this).val();

            console.log('Province selected: ' + provinceID);

            $.ajax({
                url: '{{ route("getTerritoriesByProvince", ":province") }}'.replace(':province', provinceID),
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                console.log(data); // Ajoute ceci pour vérifier la réponse
                    $('#territory_id').empty();
                    $('#territory_id').append('<option value="">Select Territory</option>');
                    $.each(data, function(key, value) {
                        $('#territory_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        });

        // Quand le territoire est sélectionnée, charger les territoires
        $('#territory_id').change(function() {
            var territoryID = $(this).val();

            console.log('Territory selected: ' + territoryID);

            $.ajax({
                url: '{{ route("getLocalitesByTerritory", ":territory") }}'.replace(':territory', territoryID),
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                console.log(data); // Ajoute ceci pour vérifier la réponse
                    $('#locality_id').empty();
                    $('#locality_id').append('<option value="">Select Locality</option>');
                    $.each(data, function(key, value) {
                        $('#locality_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });
        });
    });
</script>
