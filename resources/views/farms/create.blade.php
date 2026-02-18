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
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h6>{{ Session::get('success') }}</h6>
                            </div>
                        @endif

                        <div class="card">
                            <form method="post" action="{{ route('farms.store') }}" enctype="multipart/form-data">
                                @csrf
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
                                        <select name="farmer_id" class="form-control form-control-sm select2" id="role" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Farmer</option>
                                            @foreach($viewData['farmers'] as $farmer)
                                                <option value="{{ $farmer->id }}" {{ old('farmer_id') == $farmer->id ? 'selected' : '' }}>
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
                                        <input type="text" class="form-control" name="farm_name" value="{{ old('farm_name') }}" placeholder="Farm Name">
                                        @error('farm_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Previous Cultivated Crop -->
                                    <div class="form-group">
                                        <label>Previous Cultivated Crop</label>
                                        <input type="text" class="form-control" name="previous_cultivated_crop" value="{{ old('previous_cultivated_crop') }}" placeholder="Previous Cultivated Crop">
                                        @error('previous_cultivated_crop')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Address -->
                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Address">
                                        @error('address')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Proposed Planting Area -->
                                    <div class="form-group">
                                        <label>Proposed Planting Area (in hectares)</label>
                                        <input type="number" class="form-control" name="proposed_planting_area" value="{{ old('proposed_planting_area') }}" placeholder="Proposed Planting Area" step="0.01">
                                        @error('proposed_planting_area')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Land Topography -->
                                    <div class="form-group">
                                        <label>Land Topography</label>
                                        <input type="text" class="form-control" name="land_topography" value="{{ old('land_topography') }}" placeholder="Land Topography">
                                        @error('land_topography')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Total Land Holding -->
                                    <div class="form-group">
                                        <label>Total Land Holding (in hectares)</label>
                                        <input type="number" class="form-control" name="total_land_holding" value="{{ old('total_land_holding') }}" placeholder="Total Land Holding" step="0.01">
                                        @error('total_land_holding')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Land Ownership -->
                                    <div class="form-group">
                                        <label>Land Ownership</label>
                                        <select name="land_ownership" class="form-control form-control-sm select2" id="role" data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Ownership Type</option>
                                            <option value="own_by_family" {{ old('land_ownership') == 'own_by_family' ? 'selected' : '' }}>Own By Family</option>
                                            <option value="own_by_individual" {{ old('land_ownership') == 'own_by_individual' ? 'selected' : '' }}>Own By Individual</option>
                                            <option value="renting" {{ old('land_ownership') == 'renting' ? 'selected' : '' }}>Renting</option>
                                        </select>
                                        @error('land_ownership')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Nearby Landmark -->
                                    <div class="form-group">
                                        <label>Nearby Landmark</label>
                                        <input type="text" class="form-control" name="nearby" value="{{ old('nearby') }}" placeholder="Nearby Landmark">
                                        @error('nearby')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- GPS Location -->
                                    <div class="form-group">
                                        <label for="gps_location">GPS Location</label>
                                        <input type="text" id="gps_location" name="gps_location" class="form-control" placeholder="Select location on the map" readonly>
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
                                    </div>

                                    <!-- Documents Upload -->
                                    <div class="form-group">
                                        <label>Documents Upload</label>
                                        <input type="file" class="form-control" name="documents_upload[]" multiple>
                                        @error('documents_upload')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Registration Date -->
                                    <div class="form-group">
                                        <label>Registration Date</label>
                                        <input type="date" class="form-control" name="registration_date" value="{{ old('registration_date') }}">
                                        @error('registration_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

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
@endsection
