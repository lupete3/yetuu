@extends('layouts.backend')

<link rel="stylesheet" href="{{asset('assets/backend/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">

<script src="{{asset('assets/backend/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>


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
                        <form method="post" action="{{ route('farmers.store') }}" enctype="multipart/form-data">
                            @csrf
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
                                        value="{{ old('first_name') }}" placeholder="Farmer's First Name">
                                    @error('first_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" name="last_name"
                                        value="{{ old('last_name') }}" placeholder="Farmer's Last Name">
                                    @error('last_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Date of Birth</label>
                                    <input type="date" class="form-control" name="date_of_birth"
                                        value="{{ old('date_of_birth') }}">
                                    @error('date_of_birth')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control form-control-sm select2" id="role"
                                        data-show-subtext="true" data-live-search="true">
                                        <option value="male" {{ old('gender')=='male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender')=='female' ? 'selected' : '' }}>Female
                                        </option>
                                    </select>
                                    @error('gender')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Country</label>
                                    <select name="country_id" class="form-control form-control-sm select2" id="country"
                                        data-show-subtext="true" data-live-search="true">
                                        <option value="">Select Country</option>
                                        @foreach ($viewData['countries'] as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id')==$country->id ?
                                            'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('country_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>State/Province</label>
                                    <select name="state_province_id" class="form-control form-control-sm select2"
                                        id="state_province" data-show-subtext="true" data-live-search="true">
                                        <option value="">Select Province</option>
                                        <!-- Options will be populated based on country selection -->
                                    </select>
                                    @error('state_province_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Territory</label>
                                    <select name="territory_id" class="form-control form-control-sm select2"
                                        id="territory_id" data-show-subtext="true" data-live-search="true">
                                        <option value="">Select Territory</option>
                                        <!-- Options will be populated based on province selection -->
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
                                        <!-- Options will be populated based on province selection -->
                                    </select>
                                    @error('locality_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Village</label>
                                    <input type="text" class="form-control" name="village" value="{{ old('village') }}"
                                        placeholder="Village">
                                    @error('village')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Operational Site</label>
                                    <input type="text" class="form-control" name="operational_site"
                                        value="{{ old('operational_site') }}" placeholder="Operational Site">
                                    @error('operational_site')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Number of Family Members</label>
                                    <input type="number" class="form-control" name="number_of_family_members"
                                        value="{{ old('number_of_family_members') }}"
                                        placeholder="Number of Family Members">
                                    @error('number_of_family_members')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Main Occupation</label>
                                    <input type="text" class="form-control" name="main_occupation"
                                        value="{{ old('main_occupation') }}" placeholder="Main Occupation">
                                    @error('main_occupation')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Level of Education</label>
                                    <input type="text" class="form-control" name="level_of_education"
                                        value="{{ old('level_of_education') }}" placeholder="Level of Education">
                                    @error('level_of_education')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Civil Status</label>
                                    <select name="civil_status" class="form-control form-control-sm select2"
                                        id="civil_status" data-show-subtext="true" data-live-search="true">
                                        <option value="">Select Civil Status</option>
                                        <option value="single" {{ old('civil_status')=='single' ? 'selected' : '' }}>
                                            Single</option>
                                        <option value="married" {{ old('civil_status')=='married' ? 'selected' : '' }}>
                                            Married</option>
                                        <option value="divorced" {{ old('civil_status')=='divorced' ? 'selected' : ''
                                            }}>Divorced</option>
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
                                        <option value="{{ $accompaniment->id }}" {{
                                            old('accompaniment_id')==$accompaniment->id ?
                                            'selected' : '' }}>{{ $accompaniment->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('accompaniment_id')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Join Date</label>
                                    <input type="date" class="form-control" name="join_date"
                                        value="{{ old('join_date') }}">
                                    @error('join_date')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Priority Crop</label>
                                    <input type="text" class="form-control" name="priority_crop"
                                        value="{{ old('priority_crop') }}" placeholder="Name priority crop">
                                    @error('priority_crop')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control form-control-sm select2" id="status"
                                        data-show-subtext="true" data-live-search="true">
                                        <option value="1" {{ old('status')=='1' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="0" {{ old('status')=='0' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Member of a Producers Association</label>
                                    <select name="is_member_of_association" class="form-control form-control-sm select2"
                                        id="is_member_of_association" data-show-subtext="true" data-live-search="true">
                                        <option value="1" {{ old('is_member_of_association')=='1' ? 'selected' : '' }}>
                                            Yes</option>
                                        <option value="0" {{ old('is_member_of_association')=='0' ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                    @error('is_member_of_association')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Name of the Association (if applicable)</label>
                                    <input type="text" class="form-control" name="association_name"
                                        value="{{ old('association_name') }}" placeholder="Name of the Association">
                                    @error('association_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Contact Number</label>
                                    <input type="text" class="form-control" name="contact_number"
                                        value="{{ old('contact_number') }}" placeholder="Contact Number">
                                    @error('contact_number')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Bank Details -->
                                <div class="form-group col-md-3">
                                    <label>Mobile Money Operator (optional)</label>
                                    <select name="bank_name" class="form-control form-control-sm select2"
                                        id="bank_name" data-show-subtext="true" data-live-search="true">
                                        <option value="Airtel Money" {{ old('bank_name')=='Airtel Money' ? 'selected' : '' }}>
                                            Airtel Money</option>
                                        <option value="M-Pesa" {{ old('bank_name')=='M-Pesa' ? 'selected' : '' }}>
                                            M-Pesa</option>
                                        <option value="Orange Money" {{ old('bank_name')=='Orange Money' ? 'selected' : '' }}>
                                            Orange Money</option>
                                    </select>
                                    @error('bank_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Account Number (optional)</label>
                                    <input type="text" class="form-control" name="account_number"
                                        value="{{ old('account_number') }}" placeholder="Account Number">
                                    @error('account_number')
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
                                    @error('photo')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    @error('captured_photo')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Identity Proof -->
                                <div class="form-group col-md-3">
                                    <label>Identity Proof</label>
                                    <select name="doc_type" class="form-control form-control-sm select2" id="doc_type"
                                        data-show-subtext="true" data-live-search="true">
                                        <option value="">Select Identity Proof</option>
                                        <option value="passport" {{ old('doc_type')=='passport' ? 'selected' : '' }}>
                                            Passport</option>
                                        <option value="voting_card_id" {{ old('doc_type')=='voting_card_id' ? 'selected'
                                            : '' }}>Voting Card ID</option>
                                        <option value="driving_lisence" {{ old('doc_type')=='driving_lisence'
                                            ? 'selected' : '' }}>Driving Lisence</option>
                                    </select>

                                    @error('doc_type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remaining Basic Fields -->
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i>
                                    Save</button>
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
    $( '.select2' ).select2( {
        theme: 'bootstrap-5'
    } );
</script>

<script>
    $(document).ready(function() {
        // Quand le pays est sélectionné, charger les provinces
        $('#country').change(function() {
            var countryID = $(this).val();

            console.log('Country selected: ' + countryID);

            $.ajax({
                url: '{{ route("getProvincesByCountry", ":country") }}'.replace(':country', countryID),
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                console.log(data); // Ajoute ceci pour vérifier la réponse
                    $('#state_province').empty();
                    $('#state_province').append('<option value="">Select Province/State</option>');
                    $.each(data, function(key, value) {
                        $('#state_province').append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                }
            });

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
<script>
    var loadRecto = function(event) {
      var recto = document.getElementById('recto');
      recto.src = URL.createObjectURL(event.target.files[0]);
      recto.onload = function() {
        URL.revokeObjectURL(recto.src) // free memory
      }
    };

</script>
