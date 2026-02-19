@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('farmers.index') }}">Farmers</a></div>
                    <div class="breadcrumb-item">{{ $viewData['title'] }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissible" id="msg" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h6>{{ Session::get('success') }}</h6>
                            </div>
                        @endif

                        <div class="card">
                            <form method="post" action="{{ route('farmers.update', $farmer->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>{{ $viewData['title'] }}</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('farmers.index') }}" class="btn btn-icon icon-left btn-success">
                                            <i class="fas fa-list-alt"></i> View
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body row">
                                    <div class="form-group col-md-3">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" name="first_name"
                                            value="{{ $farmer->first_name }}">
                                        @error('first_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="last_name"
                                            value="{{ $farmer->last_name }}">
                                        @error('last_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Date of Birth</label>
                                        <input type="date" class="form-control" name="date_of_birth"
                                            value="{{ $farmer->date_of_birth }}">
                                        @error('date_of_birth')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control form-control-sm select2" id="gender"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="male" {{ $farmer->gender == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ $farmer->gender == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Country</label>
                                        <select name="country_id" class="form-control form-control-sm select2"
                                            id="country_id" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Country</option>
                                            @foreach($viewData['countries'] as $country)
                                                <option value="{{ $country->id }}" {{ $farmer->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>State/Province</label>
                                        <select name="state_province_id" class="form-control form-control-sm select2"
                                            id="state_province_id" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Province</option>
                                            <!-- Dynamic Options will be loaded here -->
                                        </select>
                                        @error('state_province')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Territory</label>
                                        <select name="territory_id" class="form-control form-control-sm select2"
                                            id="territory_id" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Territory</option>
                                            <!-- Dynamic Options will be loaded here -->
                                        </select>
                                        @error('territory_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Locality</label>
                                        <select name="locality_id" class="form-control form-control-sm select2"
                                            id="locality_id" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Locality</option>
                                            <!-- Dynamic Options will be loaded here -->
                                        </select>
                                        @error('locality_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Village</label>
                                        <input type="text" class="form-control" name="village"
                                            value="{{ $farmer->village }}">
                                        @error('village')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Operational Site</label>
                                        <input type="text" class="form-control" name="operational_site"
                                            value="{{ $farmer->operational_site }}">
                                        @error('operational_site')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Number of Family Members</label>
                                        <input type="number" class="form-control" name="number_of_family_members"
                                            value="{{ $farmer->number_of_family_members }}">
                                        @error('number_of_family_members')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Main Occupation</label>
                                        <input type="text" class="form-control" name="main_occupation"
                                            value="{{ $farmer->main_occupation }}">
                                        @error('main_occupation')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Nouveau champ : Level of Education -->
                                    <div class="form-group col-md-3">
                                        <label>Level of Education</label>
                                        <input type="text" class="form-control" name="level_of_education"
                                            value="{{ $farmer->level_of_education }}">
                                        @error('level_of_education')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Nouveau champ : Civil Status -->
                                    <div class="form-group col-md-3">
                                        <label>Civil Status</label>
                                        <select name="civil_status" class="form-control form-control-sm select2"
                                            id="civil_status" data-show-subtext="true" data-live-search="true">
                                            <option value="single" {{ $farmer->civil_status == 'single' ? 'selected' : '' }}>
                                                Single</option>
                                            <option value="married" {{ $farmer->civil_status == 'married' ? 'selected' : '' }}>Married</option>
                                            <option value="divorced" {{ $farmer->civil_status == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                        </select>
                                        @error('civil_status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Type of accompaniment</label>
                                        <select name="accompaniment_id" class="form-control form-control-sm select2"
                                            id="accompaniment" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Type of accompaniment</option>
                                            @foreach ($viewData['accompaniments'] as $accompaniment)

                                                <option value="{{ $accompaniment->id }}" {{ $farmer->accompaniement_id == $accompaniment->id ? 'selected' : '' }}>
                                                    {{ $accompaniment->name }}
                                                </option>

                                            @endforeach
                                        </select>
                                        @error('accompaniment_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Join Date</label>
                                        <input type="date" class="form-control" name="join_date"
                                            value="{{ $farmer->join_date }}">
                                        @error('join_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Priority Crop</label>
                                        <input type="text" class="form-control" name="priority_crop"
                                            value="{{ $farmer->priority_culture }}" placeholder="Name priority crop">
                                        @error('priority_crop')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control form-control-sm select2" id="status"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="1" {{ $farmer->status ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ !$farmer->status ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Nouveau champ : Member of a Producers Association -->
                                    <div class="form-group col-md-3">
                                        <label>Member of a Producers Association</label>
                                        <select name="is_member_of_association" class="form-control form-control-sm select2"
                                            id="is_member_of_association" data-show-subtext="true" data-live-search="true">
                                            <option value="1" {{ $farmer->is_member_of_association ? 'selected' : '' }}>Yes
                                            </option>
                                            <option value="0" {{ !$farmer->is_member_of_association ? 'selected' : '' }}>No
                                            </option>
                                        </select>
                                        @error('is_member_of_association')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Nouveau champ : Name of the Association -->
                                    <div class="form-group col-md-3">
                                        <label>Name of the Association (if applicable)</label>
                                        <input type="text" class="form-control" name="association_name"
                                            value="{{ $farmer->association_name }}">
                                        @error('association_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Contact Number</label>
                                        <input type="text" class="form-control" name="contact_number"
                                            value="{{ $farmer->contact_number }}">
                                        @error('contact_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Bank Details -->

                                    <div class="form-group col-md-3">
                                        <label>Mobile Money Operator (optional)</label>
                                        <select name="bank_name" class="form-control form-control-sm select2" id="bank_name"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="Airtel Money" {{ $farmer->bank_name == 'Airtel Money' ? 'selected' : '' }}>Airtel Money</option>
                                            <option value="M-Pesa" {{ $farmer->bank_name == 'M-Pesa' ? 'selected' : '' }}>
                                                M-Pesa</option>
                                            <option value="Orange Money" {{ $farmer->bank_name == 'Orange Money' ? 'selected' : '' }}>Orange Money</option>
                                        </select>
                                        @error('bank_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Account Number (optional)</label>
                                        <input type="text" class="form-control" name="account_number"
                                            value="{{ $farmer->account_number }}" placeholder="Account Number">
                                        @error('account_number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Identity Proof -->
                                    <div class="form-group col-md-3">
                                        <label>Identity Proof</label>
                                        <select name="doc_type" class="form-control form-control-sm select2" id="doc_type"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Identity Proof</option>
                                            <option value="passport" {{ $farmer->doc_type == 'passport' ? 'selected' : '' }}>
                                                Passport</option>
                                            <option value="voting_card_id" {{ $farmer->doc_type == 'voting_card_id' ? 'selected' : '' }}>Voting Card ID</option>
                                            <option value="driving_lisence" {{ $farmer->doc_type == 'driving_lisence' ? 'selected' : '' }}>Driving Lisence</option>
                                        </select>
                                        @error('doc_type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label>Photo</label>
                                        <input type="file" class="form-control-file" name="photo">
                                        <button type="button" id="startCameraButton" class="btn btn-success mt-2">Start
                                            Camera</button>
                                        <button type="button" id="captureButton" class="btn btn-success mt-2"
                                            style="display: none;">Capture Photo</button>

                                        <!-- Camera and capture elements -->
                                        <video id="cameraPreview" autoplay
                                            style="display: none; width: 100%; max-width: 400px;"></video>
                                        <canvas id="canvas" style="display: none;"></canvas>
                                        <!-- Prévisualisation de la photo capturée -->
                                        <div id="previewContainer" style="display: none;">
                                            <p>Preview:</p>
                                            <img id="photoPreview" src="" alt="Photo Preview"
                                                style="width: 320px; height: 240px;" />
                                        </div>
                                        <input type="hidden" name="captured_photo" id="captured_photo">
                                        @if($farmer->photo)
                                            <div class="mt-3">
                                                <label>Current Photo:</label>
                                                <img src="{{ asset('storage/' . $farmer->photo) }}" alt="Farmer Photo"
                                                    class="img-thumbnail" width="150">
                                            </div>
                                        @endif
                                        @error('photo')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                                        Update</button>
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

<script src="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.js"></script>

<script>
    mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';

    const map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [28.0339, 1.6596],
        zoom: 5
    });

    const marker = new mapboxgl.Marker({
        draggable: true
    })
        .setLngLat([28.0339, 1.6596])
        .addTo(map);

    function onDragEnd() {
        const lngLat = marker.getLngLat();
        document.getElementById('gps_location').value = lngLat.lng + ', ' + lngLat.lat;
    }

    marker.on('dragend', onDragEnd);

    map.on('click', (e) => {
        const coords = e.lngLat;
        marker.setLngLat(coords);
        document.getElementById('gps_location').value = coords.lng + ', ' + coords.lat;
    });

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            const userLocation = [position.coords.longitude, position.coords.latitude];
            map.setCenter(userLocation);
            map.setZoom(15);
            marker.setLngLat(userLocation);
            document.getElementById('gps_location').value = userLocation[0] + ', ' + userLocation[1];
        }, (error) => {
            console.error('Error getting location:', error);
            alert('Unable to retrieve your location. Please allow location access.');
        });
    } else {
        alert('Geolocation is not supported by your browser.');
    }
</script>

<script>
    $(document).ready(function () {
        // Chargement initial des provinces lorsqu'un pays est sélectionné
        $('#country_id').change(function () {
            var countryID = $(this).val();
            if (countryID) {
                $.ajax({
                    url: '{{ route("getProvincesByCountry", ":country") }}'.replace(':country', countryID),
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#state_province_id').empty();
                        $('#state_province_id').append('<option value="">Select Province/State</option>');
                        $.each(data, function (key, value) {
                            $('#state_province_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });

                        // Sélectionner la province existante si elle est définie
                        var selectedProvince = '{{ $farmer->state_province_id }}';
                        if (selectedProvince) {
                            $('#state_province_id').val(selectedProvince).trigger('change'); // Déclencher l'événement change
                        }
                    }
                });
            } else {
                $('#state_province_id').empty().append('<option value="">Select Province/State</option>');
            }
        });

        // Chargement initial des territoires lorsqu'une province est sélectionnée
        $('#state_province_id').change(function () {
            var provinceID = $(this).val();
            if (provinceID) {
                $.ajax({
                    url: '{{ route("getTerritoriesByProvince", ":province") }}'.replace(':province', provinceID),
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#territory_id').empty();
                        $('#territory_id').append('<option value="">Select Territory</option>');
                        $.each(data, function (key, value) {
                            $('#territory_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });

                        // Sélectionner le territoire existant si défini
                        var selectedTerritory = '{{ $farmer->territory_id }}';
                        if (selectedTerritory) {
                            $('#territory_id').val(selectedTerritory).trigger('change'); // Déclencher l'événement change
                        }
                    }
                });
            } else {
                $('#territory_id').empty().append('<option value="">Select Territory</option>');
            }
        });

        // Chargement initial des localités lorsqu'un territoire est sélectionné
        $('#territory_id').change(function () {
            var territoryID = $(this).val();
            if (territoryID) {
                $.ajax({
                    url: '{{ route("getLocalitesByTerritory", ":territory") }}'.replace(':territory', territoryID),
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#locality_id').empty();
                        $('#locality_id').append('<option value="">Select Locality</option>');
                        $.each(data, function (key, value) {
                            $('#locality_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });

                        // Sélectionner la localité existante si définie
                        var selectedLocality = '{{ $farmer->groupement_id }}';
                        if (selectedLocality) {
                            $('#locality_id').val(selectedLocality);
                        }
                    }
                });
            } else {
                $('#locality_id').empty().append('<option value="">Select Locality</option>');
            }
        });

        // Déclencher automatiquement le changement de pays au chargement de la page
        var selectedCountry = '{{ $farmer->country_id }}';
        if (selectedCountry) {
            $('#country_id').val(selectedCountry).trigger('change'); // Charger les provinces
        }


        // Camera capture functionality
        const startCameraButton = document.getElementById('startCameraButton');
        const captureButton = document.getElementById('captureButton');
        const cameraPreview = document.getElementById('cameraPreview');
        const canvas = document.getElementById('canvas');
        const capturedPhotoInput = document.getElementById('captured_photo');
        const photoPreview = document.getElementById('photoPreview');
        const previewContainer = document.getElementById('previewContainer');
        let videoStream = null;

        // Start the camera
        startCameraButton.addEventListener('click', async () => {
            videoStream = await navigator.mediaDevices.getUserMedia({ video: true });
            cameraPreview.srcObject = videoStream;
            cameraPreview.style.display = 'block';
            captureButton.style.display = 'inline-block';
        });

        // Capture photo
        captureButton.addEventListener('click', () => {
            const context = canvas.getContext('2d');
            canvas.width = cameraPreview.videoWidth;
            canvas.height = cameraPreview.videoHeight;
            context.drawImage(cameraPreview, 0, 0, canvas.width, canvas.height);

            const imageDataURL = canvas.toDataURL('image/png');
            capturedPhotoInput.value = imageDataURL;

            // Show preview
            photoPreview.src = imageDataURL;
            previewContainer.style.display = 'block';

            // Stop the video stream
            videoStream.getTracks().forEach(track => track.stop());
            cameraPreview.style.display = 'none';
            captureButton.style.display = 'none';
        });
    });
</script>