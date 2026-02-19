@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Field Visit Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('field_visits.index') }}">Land Visits</a></div>
                    <div class="breadcrumb-item">Land Visit Record</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-10 col-lg-8 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ $fieldVisit->field->field_name . ' (' . $fieldVisit->field->farmer->last_name . ' ' . $fieldVisit->field->farmer->first_name . ')' ?? 'N/A' }}
                                    - {{ $fieldVisit->visit_date }}</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('field_visits.edit', $fieldVisit->id) }}"
                                        class="btn btn-icon icon-left btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('field_visits.index') }}" class="btn btn-icon icon-left btn-info">
                                        <i class="fas fa-list-alt"></i> Back to List
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <strong>Staff field name:</strong> <span
                                            class="text-success">{{ $fieldVisit->user->name ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Land name:</strong> <span
                                            class="text-success">{{ $fieldVisit->field->field_name . ' (' . $fieldVisit->field->farmer->last_name . ' ' . $fieldVisit->field->farmer->first_name . ')' ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Visit date:</strong> <span
                                            class="text-success">{{ $fieldVisit->visit_date }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Notes:</strong> <span
                                            class="text-success">{{ $fieldVisit->notes ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Estimated yield:</strong> <span
                                            class="text-success">{{ $fieldVisit->estimated_yield ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>GPS:</strong> <span
                                            class="text-success">{{ $fieldVisit->gps_location ?? 'N/A' }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Photos:</strong>
                                        <div class="mt-2">
                                            @if($fieldVisit->photos)
                                                <div class="row">
                                                    @foreach(json_decode($fieldVisit->photos) as $photo)
                                                        <div class="col-md-3 mb-2">
                                                            <a href="{{ asset('storage/' . $photo) }}" target="_blank">
                                                                <img src="{{ asset('storage/' . $photo) }}" class="img-thumbnail"
                                                                    alt="Photo">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-danger">No photos available</span>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                                <div id="map"
                                    style="width: 100%; height: 300px; margin-top: 20px; border: 1px solid #ddd; border-radius: 8px;">
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.js"></script>

    <script>
        mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';

        const initialCoordinates = "{{ $fieldVisit->gps_location }}" ?
            "{{ $fieldVisit->gps_location }}".split(',').map(coord => parseFloat(coord.trim())) :
            [28.0339, 1.6596];

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: initialCoordinates,
            zoom: 12
        });

        new mapboxgl.Marker()
            .setLngLat(initialCoordinates)
            .addTo(map);
    </script>

@endsection