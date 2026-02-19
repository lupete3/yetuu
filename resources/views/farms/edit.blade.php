@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('farms.index') }}">Farms</a></div>
                    <div class="breadcrumb-item">{{ $viewData['title'] }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissible" id="msg" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h6 class="text-success">{{ Session::get('success') }}</h6>
                            </div>
                        @endif

                        <div class="card">
                            <form method="post" action="{{ route('farms.update', $farm->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>{{ $viewData['title'] }}</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('farms.index') }}" class="btn btn-icon icon-left btn-success">
                                            <i class="fas fa-list-alt"></i> View
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <!-- Farmer Selection -->
                                    <div class="form-group">
                                        <label>Farmer</label>
                                        <select name="farmer_id" class="form-control form-control-sm select2" id="role"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Farmer</option>
                                            @foreach($viewData['farmers'] as $farmer)
                                                <option value="{{ $farmer->id }}" {{ $farm->farmer_id == $farmer->id ? 'selected' : '' }}>
                                                    {{ $farmer->first_name }} {{ $farmer->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('farmer_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Farm Name -->
                                    <div class="form-group">
                                        <label>Farm Name</label>
                                        <input type="text" class="form-control" name="farm_name"
                                            value="{{ $farm->farm_name }}" placeholder="Farm Name">
                                        @error('farm_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Previous Cultivated Crop -->
                                    <div class="form-group">
                                        <label>Previous Cultivated Crop</label>
                                        <input type="text" class="form-control" name="previous_cultivated_crop"
                                            value="{{ $farm->previous_cultivated_crop }}"
                                            placeholder="Previous Cultivated Crop">
                                        @error('previous_cultivated_crop')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ $farm->address }}"
                                            placeholder="Address">
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Proposed Planting Area -->
                                    <div class="form-group">
                                        <label>Proposed Planting Area (in hectares)</label>
                                        <input type="number" class="form-control" name="proposed_planting_area"
                                            value="{{ $farm->proposed_planting_area }}" placeholder="Proposed Planting Area"
                                            step="0.01">
                                        @error('proposed_planting_area')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Land Topography -->
                                    <div class="form-group">
                                        <label>Land Topography</label>
                                        <input type="text" class="form-control" name="land_topography"
                                            value="{{ $farm->land_topography }}" placeholder="Land Topography">
                                        @error('land_topography')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Total Land Holding -->
                                    <div class="form-group">
                                        <label>Total Land Holding (in hectares)</label>
                                        <input type="number" class="form-control" name="total_land_holding"
                                            value="{{ $farm->total_land_holding }}" placeholder="Total Land Holding"
                                            step="0.01">
                                        @error('total_land_holding')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Land Ownership -->
                                    <div class="form-group">
                                        <label>Land Ownership</label>
                                        <select class="form-control" name="land_ownership">
                                            <option value="">Select Ownership Type</option>
                                            <option value="own_by_family" {{ $farm->land_ownership == 'own_by_family' ? 'selected' : '' }}>Own By Family</option>
                                            <option value="own_by_individual" {{ $farm->land_ownership == 'own_by_individual' ? 'selected' : '' }}>Own By Individual</option>
                                            <option value="renting" {{ $farm->land_ownership == 'renting' ? 'selected' : '' }}>Renting</option>
                                        </select>
                                        @error('land_ownership')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Nearby Landmark -->
                                    <div class="form-group">
                                        <label>Nearby Landmark</label>
                                        <input type="text" class="form-control" name="nearby" value="{{ $farm->nearby }}"
                                            placeholder="Nearby Landmark">
                                        @error('nearby')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- GPS Location -->
                                    <div class="form-group">
                                        <label for="gps_location">GPS Location</label>
                                        <input type="text" id="gps_location" name="gps_location"
                                            value="{{ $farm->gps_location }}" class="form-control"
                                            placeholder="Select location on the map" readonly>
                                        @error('gps_location')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div id='map' style='width: 100%; height: 400px;'></div>

                                    <!-- Photo Upload -->
                                    <div class="form-group">
                                        <label>Farm Photo</label>
                                        <input type="file" class="form-control" name="photo" accept="image/*">
                                        @error('photo')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        @if($farm->photo)
                                            <div class="mt-3">
                                                <label>Current Photo:</label>
                                                <img src="{{ asset('storage/' . $farm->photo) }}" alt="Farmer Photo"
                                                    class="img-thumbnail" width="150">
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Documents Upload -->
                                    <div class="form-group">
                                        <label>Documents Upload</label>
                                        <input type="file" class="form-control" name="documents_upload[]" multiple>
                                        @error('documents_upload')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        @if($farm->documents_upload)
                                            <div class="mt-3">
                                                <label>Remove documents by selecting the checkbox:</label>
                                                <div class="row">
                                                    @foreach($farm->documents_upload as $index => $document)
                                                        <div class="col-md-3" id="document-{{ $index }}">
                                                            <div class="form-check">
                                                                <input type="checkbox" name="remove_documents[]"
                                                                    value="{{ $document['filename'] }}"
                                                                    class="form-check-input remove-document"
                                                                    data-document-id="{{ $document['filename'] }}"
                                                                    id="remove-document-{{ $index }}">
                                                                <label class="form-check-label" for="remove-document-{{ $index }}">
                                                                    <a href="{{ asset('storage/' . $document['path']) }}"
                                                                        target="_blank">{{ $document['filename'] }}</a>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Registration Date -->
                                    <div class="form-group">
                                        <label>Registration Date</label>
                                        <input type="date" class="form-control" name="registration_date"
                                            value="{{ $farm->registration_date }}">
                                        @error('registration_date')
                                            <div class="text-danger">{{ $message }}</div>
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

    <!-- Mapbox and Scripts -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.js"></script>
    <script src="{{ asset('assets/backend/modules/jquery.min.js') }}"></script>


    <script>
        mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';

        const initialCoordinates = "{{ $farm->gps_location }}" ?
            "{{ $farm->gps_location }}".split(',').map(coord => parseFloat(coord.trim())) :
            [28.0339, 1.6596];

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: initialCoordinates,
            zoom: 12
        });

        const marker = new mapboxgl.Marker({ draggable: true })
            .setLngLat(initialCoordinates)
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

        document.querySelectorAll('.remove-document').forEach((checkbox, index) => {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    let documentId = this.getAttribute('data-document-id');

                    fetch("{{ route('farms.remove_document', $farm->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ document: documentId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('document-' + index).remove();
                            } else {
                                alert('An error occurred while removing the document.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        });
    </script>

@endsection