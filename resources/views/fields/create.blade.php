@extends('layouts.backend')

    <!-- Inclure les styles et scripts de Mapbox -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.7.0/mapbox-gl.js"></script>
    <script src="https://unpkg.com/@turf/turf@6/turf.min.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.3/mapbox-gl-draw.js"></script>
    <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.3/mapbox-gl-draw.css" type="text/css">

    <style>
        /* Style de base */
        #map {
            width: 100%;
            height: 400px;
            margin-bottom: 20px;
        }
    </style>

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('fields.index') }}">Land Plots</a></div>
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
                            <form method="post" action="{{ route('fields.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4>{{ $viewData['title'] }}</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('fields.index') }}" class="btn btn-icon icon-left btn-success">
                                            <i class="fas fa-list-alt"></i> View
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body row">
                                    <!-- Farmer Selection -->
                                    <div class="form-group col-md-4">
                                        <label>Farmer</label>
                                        <select class="form-control" name="farmer_id">
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

                                    <!-- Leand Plot Name -->
                                    <div class="form-group col-md-4">
                                        <label>Land Plot Name</label>
                                        <input type="text" class="form-control" name="field_name" value="{{ old('field_name') }}" placeholder="Leand Plot Name">
                                        @error('field_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Total Area -->
                                    <div class="form-group col-md-4">
                                        <label>Total Area (in hectares)</label>
                                        <input type="number" class="form-control" name="total_area" value="{{ old('total_area') }}" placeholder="Total area in hectares">
                                        @error('total_area')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Soil Type -->
                                    <div class="form-group col-md-4">
                                        <label>Soil Type</label>
                                        <select class="form-control form-control-sm select2" data-show-subtext="true" data-live-search="true"  name="soil_type">
                                            <option value="">Select Soil Type</option>
                                            <option value="Sandy" {{ old('soil_type') == 'Sandy' ? 'selected' : '' }}>Sandy</option>
                                            <option value="Clay" {{ old('soil_type') == 'Clay' ? 'selected' : '' }}>Clay</option>
                                            <option value="Silty" {{ old('soil_type') == 'Silty' ? 'selected' : '' }}>Silty</option>
                                            <option value="Loamy" {{ old('soil_type') == 'Loamy' ? 'selected' : '' }}>Loamy</option>
                                            <option value="Peaty" {{ old('soil_type') == 'Peaty' ? 'selected' : '' }}>Peaty</option>
                                            <option value="Chalky" {{ old('soil_type') == 'Chalky' ? 'selected' : '' }}>Chalky</option>
                                        </select>
                                        @error('soil_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Irrigation Type -->
                                    <div class="form-group col-md-4">
                                        <label>Irrigation Type</label>
                                        <select class="form-control form-control-sm select2" data-show-subtext="true" data-live-search="true"  name="irrigation_type">
                                            <option value="">Select Irrigation Type</option>
                                            <option value="Drip" {{ old('irrigation_type') == 'Drip' ? 'selected' : '' }}>Drip</option>
                                            <option value="Sprinkler" {{ old('irrigation_type') == 'Sprinkler' ? 'selected' : '' }}>Sprinkler</option>
                                            <option value="Surface" {{ old('irrigation_type') == 'Surface' ? 'selected' : '' }}>Surface</option>
                                            <option value="Furrow" {{ old('irrigation_type') == 'Furrow' ? 'selected' : '' }}>Furrow</option>
                                            <option value="Subsurface" {{ old('irrigation_type') == 'Subsurface' ? 'selected' : '' }}>Subsurface</option>
                                        </select>
                                        @error('irrigation_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Registration Date -->
                                    <div class="form-group col-md-4">
                                        <label>Registration Date</label>
                                        <input type="date" class="form-control" name="registration_date" value="{{ old('registration_date') }}">
                                        @error('registration_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Carte Mapbox -->
                                    <div id="map"></div>

                                    <!-- Champ caché pour les coordonnées du polygone -->
                                    <input type="hidden" id="gps_location" name="gps_location">
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
        // Initialiser la carte avec Mapbox
        mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [28.2639, -1.9578], // Coordonées centrées par défaut
            zoom: 12
        });

        // Ajout du contrôle de dessin
        map.on('load', () => {
            const draw = new MapboxDraw({
                displayControlsDefault: false,
                controls: {
                    polygon: true,
                    trash: true
                }
            });
            map.addControl(draw);

            // Sauvegarder les coordonnées du polygone dans le champ caché
            map.on('draw.create', updatePolygonCoordinates);
            map.on('draw.update', updatePolygonCoordinates);
            map.on('draw.delete', clearPolygonCoordinates);

            function updatePolygonCoordinates(e) {
                const data = draw.getAll();
                if (data.features.length > 0) {
                    const coordinates = data.features[0].geometry.coordinates[0];
                    document.getElementById('gps_location').value = JSON.stringify(coordinates);
                }
            }

            function clearPolygonCoordinates() {
                document.getElementById('gps_location').value = '';
            }
        });
    </script>
@endsection
