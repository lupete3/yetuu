@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('farmlabours.index') }}">Farm labours</a></div>
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
                            <form method="post" action="{{ route('farmlabours.update', $farmlabour->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>{{ $viewData['title'] }}</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('farmlabours.index') }}"
                                            class="btn btn-icon icon-left btn-success">
                                            <i class="fas fa-list-alt"></i> View
                                        </a>
                                    </div>
                                </div>


                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Farmer</label>
                                        <select name="farmer_id" class="form-control form-control-sm select2"
                                            data-show-subtext="true" data-live-search="true" required>
                                            @foreach($viewData['farmers'] as $farmer)
                                                <option value="{{ $farmer->id }}" {{ $farm->farmer_id == $farmer->id ? 'selected' : '' }}>
                                                    {{ $farmer->first_name }} {{ $farmer->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Farm Name</label>
                                        <input type="text" class="form-control" name="farm_name"
                                            value="{{ $farm->farm_name }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Previous Cultivated Crop</label>
                                        <input type="text" class="form-control" name="previous_cultivated_crop"
                                            value="{{ $farm->previous_cultivated_crop }}"
                                            placeholder="Previous Cultivated Crop">
                                    </div>

                                    <div class="form-group">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" value="{{ $farm->address }}"
                                            required>
                                    </div>

                                    <div class="form-group">
                                        <label>Proposed Planting Area (in hectares)</label>
                                        <input type="number" class="form-control" name="proposed_planting_area"
                                            value="{{ $farm->proposed_planting_area }}" step="0.01" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Land Topography</label>
                                        <input type="text" class="form-control" name="land_topography"
                                            value="{{ $farm->land_topography }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Total Land Holding (in hectares)</label>
                                        <input type="number" class="form-control" name="total_land_holding"
                                            value="{{ $farm->total_land_holding }}" step="0.01" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Land Ownership</label>
                                        <select name="land_ownership" class="form-control" required>
                                            <option value="leased" {{ $farm->land_ownership == 'leased' ? 'selected' : '' }}>
                                                Leased</option>
                                            <option value="owned" {{ $farm->land_ownership == 'owned' ? 'selected' : '' }}>
                                                Owned</option>
                                            <option value="renting" {{ $farm->land_ownership == 'renting' ? 'selected' : '' }}>Renting</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Nearby Landmarks</label>
                                        <input type="text" class="form-control" name="nearby" value="{{ $farm->nearby }}"
                                            placeholder="Nearby Landmarks">
                                    </div>

                                    <div class="form-group">
                                        <label for="gps_location">GPS Location</label>
                                        <input type="text" id="gps_location" name="gps_location" class="form-control"
                                            value="{{ $farm->gps_location }}" placeholder="Select location on the map"
                                            readonly required>
                                    </div>

                                    <div id='map' style='width: 100%; height: 400px;'></div>

                                    <div class="form-group">
                                        <label>Photo</label>
                                        <input type="file" name="photo" class="form-control">
                                        @if($farm->photo)
                                            <div class="mt-3">
                                                <label>Current Photo:</label>
                                                <img src="{{ asset('storage/' . $farm->photo) }}" alt="Farmer Photo"
                                                    class="img-thumbnail" width="150">
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label>Upload Documents</label>
                                        <input type="file" name="documents_upload[]" class="form-control" multiple>
                                    </div>

                                    @if($farm->documents_upload)
                                        <div class="mt-3">
                                            <label>Remove documents by selecting the checkbox:</label>
                                            <div class="row">
                                                @foreach($farm->documents_upload as $index => $document)
                                                    <div class="col-md-2" id="document-{{ $index }}">
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

                                    <div class="form-group">
                                        <label>Registration Date</label>
                                        <input type="date" class="form-control" name="registration_date"
                                            value="{{ $farm->registration_date }}" required>
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