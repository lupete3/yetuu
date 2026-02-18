@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Tableau de bord</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('field_visits.index') }}">Lands Visit</a></div>
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
                            <form method="post" action="{{ route('field_visits.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4>{{ $viewData['title'] }}</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('field_visits.index') }}"
                                            class="btn btn-icon icon-left btn-success">
                                            <i class="fas fa-list-alt"></i> View
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body row">
                                    <div class="form-group col-md-4">
                                        <label>Field staff</label>
                                        <select name="field_staff_id" class="form-control form-control-sm select2"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="">Select field staff</option>
                                            @foreach($viewData['staffs'] as $staff)
                                                <option value="{{ $staff->id }}" {{ old('field_staff_id') == $staff->id ? 'selected' : '' }}>
                                                    {{ $staff->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('field_staff_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Land</label>
                                        <select name="field_id" class="form-control form-control-sm select2"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="">Select land</option>
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

                                    <div class="form-group col-md-4">
                                        <label>Visit date</label>
                                        <input type="date" class="form-control" name="visit_date"
                                            value="{{ old('visit_date') }}">
                                        @error('visit_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Notes</label>
                                        <textarea class="form-control" name="notes"
                                            placeholder="Visit notes">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Estimated yeald</label>
                                        <input type="text" class="form-control" name="estimated_yield"
                                            value="{{ old('estimated_yield') }}">
                                        @error('estimated_yield')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Photos</label>
                                        <input type="file" class="form-control" name="photos[]" multiple>
                                        <small class="form-text text-muted">You can upload multiple pictures.</small>
                                        @error('photos')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- GPS Location -->
                                    <div class="form-group col-md-6">
                                        <label for="gps_location">GPS Location</label>
                                        <input type="text" id="gps_location" name="gps_location" class="form-control"
                                            placeholder="Select location on the map" readonly>
                                        @error('gps_location')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div id='map' style='width: 100%; height: 400px;'></div>

                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check"></i>
                                        Enregistrer</button>
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