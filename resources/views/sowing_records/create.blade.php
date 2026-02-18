@extends('layouts.backend')

<!-- Include Mapbox styles and scripts -->
<link href="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.js"></script>
<script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.3/mapbox-gl-draw.js"></script>
<link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.3/mapbox-gl-draw.css"
    type="text/css">

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('sowing-records.index') }}">Sowing Records</a></div>
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
                            <form method="post" action="{{ route('sowing-records.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4>{{ $viewData['title'] }}</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('sowing-records.index') }}"
                                            class="btn btn-icon icon-left btn-success">
                                            <i class="fas fa-list-alt"></i> List of Sowing Records
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Field</label>
                                        <select name="field_id" class="form-control form-control-sm select2"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Field</option>
                                            @foreach($viewData['fields'] as $field)
                                                <option value="{{ $field->id }}" {{ old('field_id') == $field->id ? 'selected' : '' }}>
                                                    {{ $field->field_name . ' (' . $field->farmer->last_name . ' ' . $field->farmer->first_name . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('field_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Crop</label>
                                        <select name="crop_id" class="form-control form-control-sm select2"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="">Select Crop</option>
                                            @foreach($viewData['crops'] as $crop)
                                                <option value="{{ $crop->id }}" {{ old('crop_id') == $crop->id ? 'selected' : '' }}>
                                                    {{ $crop->crop_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('crop_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Sowing Date</label>
                                        <input type="date" class="form-control" name="sowing_date"
                                            value="{{ old('sowing_date') }}">
                                        @error('sowing_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Area Sown (ha)</label>
                                        <input type="text" class="form-control" name="area_sown"
                                            value="{{ old('area_sown') }}">
                                        @error('area_sown')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <label>GPS Coordinates</label>
                                    <div id='map' style='width: 100%; height: 400px;'></div>

                                    <input type="text" id="gps_coordinates" name="gps_coordinates" class="form-control"
                                        placeholder="Select location on the map" readonly>
                                    @error('gps_coordinates')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror

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

    <script>
        // Initialize the map with Mapbox
        mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [28.2639, -1.9578], // Default coordinates (example: Bunagana)
            zoom: 12
        });

        // Add drawing control
        map.on('load', () => {
            const draw = new MapboxDraw({
                displayControlsDefault: false,
                controls: {
                    polygon: true,
                    trash: true
                }
            });
            map.addControl(draw);

            // Save polygon coordinates in the hidden input field
            map.on('draw.create', updatePolygonCoordinates);
            map.on('draw.update', updatePolygonCoordinates);
            map.on('draw.delete', clearPolygonCoordinates);

            function updatePolygonCoordinates(e) {
                const data = draw.getAll();
                if (data.features.length > 0) {
                    const coordinates = data.features[0].geometry.coordinates[0];
                    document.getElementById('gps_coordinates').value = JSON.stringify(coordinates);
                }
            }

            function clearPolygonCoordinates() {
                document.getElementById('gps_coordinates').value = '';
            }
        });
    </script>

@endsection