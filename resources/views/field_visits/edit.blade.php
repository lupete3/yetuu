@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('field_visits.index') }}">Land visits</a></div>
                    <div class="breadcrumb-item">{{ $viewData['title'] }}</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        @if($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible" id="msg" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                    <h6>{{ $error }}</h6>
                                </div>
                            @endforeach
                        @endif
                        @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissible" id="msg" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h6>{{ Session::get('success') }}</h6>
                            </div>
                        @endif

                        <div class="card">
                            <form method="post" action="{{ route('field_visits.update', $fieldVisit->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
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
                                                <option value="{{ $staff->id }}" {{ $fieldVisit->field_staff_id == $staff->id ? 'selected' : '' }}>
                                                    {{ $staff->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('field_staff_id')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Field</label>
                                        <select name="field_id" class="form-control form-control-sm select2"
                                            data-show-subtext="true" data-live-search="true">
                                            <option value="">Select land</option>
                                            @foreach($viewData['fields'] as $field)
                                                <option value="{{ $field->id }}" {{ $field->id == $fieldVisit->field_id ? 'selected' : '' }}>
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
                                            value="{{ $fieldVisit->visit_date }}">
                                        @error('visit_date')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Notes</label>
                                        <textarea class="form-control" name="notes"
                                            placeholder="Visit notes">{{ $fieldVisit->notes }}</textarea>
                                        @error('notes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Estimated yeald</label>
                                        <input type="text" class="form-control" name="estimated_yield"
                                            value="{{ $fieldVisit->estimated_yield }}">
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

                                        @if($fieldVisit->photos)
                                            <div class="mt-3">
                                                <label>Remove pictures by selecting the checkbox :</label>
                                                <div class="row">
                                                    @foreach(json_decode($fieldVisit->photos) as $index => $photo)
                                                        <div class="col-md-4" id="photo-{{ $index }}">
                                                            <div class="form-check">
                                                                <input type="checkbox" name="remove_photos[]" value="{{ $photo }}"
                                                                    class="form-check-input remove-photo"
                                                                    data-photo-id="{{ $photo }}" id="remove-photo-{{ $index }}">
                                                                <label class="form-check-label" for="remove-photo-{{ $index }}">
                                                                    <a href="{{ asset('storage/app/public/' . $photo) }}"
                                                                        target="_blank">
                                                                        <img src="{{ asset('storage/app/public/' . $photo) }}"
                                                                            class="img-thumbnail" alt="Photo">
                                                                    </a>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- GPS Location -->
                                    <div class="form-group col-md-6">
                                        <label for="gps_location">GPS Location</label>
                                        <input type="text" id="gps_location" name="gps_location"
                                            value="{{ $fieldVisit->gps_location }}" class="form-control"
                                            placeholder="Select location on the map" readonly>
                                        @error('gps_location')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div id='map' style='width: 100%; height: 400px;'></div>
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

        const initialCoordinates = "{{ $fieldVisit->gps_location }}" ?
            "{{ $fieldVisit->gps_location }}".split(',').map(coord => parseFloat(coord.trim())) :
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

        document.querySelectorAll('.remove-photo').forEach((checkbox, index) => {
            checkbox.addEventListener('change', function () {
                if (this.checked) {
                    let photoId = this.getAttribute('data-photo-id');

                    // Envoi de la requête AJAX pour supprimer la photo
                    fetch("{{ route('field_visits.remove_photo', $fieldVisit->id) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: JSON.stringify({ photo: photoId })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Retirer la photo du DOM
                                document.getElementById('photo-' + index).remove();
                            } else {
                                alert('Une erreur est survenue lors de la suppression de la photo.');
                            }
                        })
                        .catch(error => console.error('Erreur:', error));
                }
            });
        });

    </script>

@endsection