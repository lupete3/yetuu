@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('crop-management.index') }}">Crops List</a></div>
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
                            <form method="post" action="{{ route('crop-management.update', $crop->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>{{ $viewData['title'] }}</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('crop-management.index') }}"
                                            class="btn btn-icon icon-left btn-success">
                                            <i class="fas fa-list-alt"></i> View
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body row">
                                    <div class="form-group col-md-4">
                                        <label>Crop ID</label>
                                        <input type="text" class="form-control" value="{{ $crop->crop_id }}"
                                            placeholder="Unique Crop ID" disabled>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Growing Season</label>
                                        <input type="text" class="form-control" name="growing_season"
                                            value="{{ old('growing_season', $crop->growing_season) }}"
                                            placeholder="Growing Season" required>
                                        @error('growing_season')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Farmer</label>
                                        <select name="farmer_id" class="form-control form-control-sm select2"
                                            data-show-subtext="true" data-live-search="true" required>
                                            @foreach($viewData['farmers'] as $farmer)
                                                <option value="{{ $farmer->id }}" {{ $crop->farmer_id == $farmer->id ? 'selected' : '' }}>
                                                    {{ $farmer->first_name }} {{ $farmer->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Crop Type</label>
                                        <input type="text" class="form-control" name="crop_type"
                                            value="{{ old('crop_type', $crop->crop_type) }}" placeholder="Type of Crop"
                                            required>
                                        @error('crop_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Variety Name</label>
                                        <input type="text" class="form-control" name="variety_name"
                                            value="{{ old('variety_name', $crop->variety_name) }}"
                                            placeholder="Variety Name (optional)">
                                        @error('variety_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Disease Resistance</label>
                                        <input type="text" class="form-control" name="disease_resistance"
                                            value="{{ old('disease_resistance', $crop->disease_resistance) }}"
                                            placeholder="Disease Resistance (optional)">
                                        @error('disease_resistance')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Growth Duration (in days)</label>
                                        <input type="number" class="form-control" name="growth_duration"
                                            value="{{ old('growth_duration', $crop->growth_duration) }}"
                                            placeholder="Growth Duration (optional)">
                                        @error('growth_duration')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Fertilizer Requirements</label>
                                        <input type="text" class="form-control" name="fertilizer_requirements"
                                            value="{{ old('fertilizer_requirements', $crop->fertilizer_requirements) }}"
                                            placeholder="Fertilizer Requirements (optional)">
                                        @error('fertilizer_requirements')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Sowing Date</label>
                                        <input type="date" class="form-control" name="planting_date"
                                            value="{{ old('planting_date', $crop->planting_date) }}" required>
                                        @error('planting_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Harvest Date</label>
                                        <input type="date" class="form-control" name="harvest_date"
                                            value="{{ old('harvest_date', $crop->harvest_date) }}">
                                        @error('harvest_date')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Growth Stage</label>
                                        <input type="text" class="form-control" name="growth_stage"
                                            value="{{ old('growth_stage', $crop->growth_stage) }}"
                                            placeholder="Growth Stage (optional)">
                                        @error('growth_stage')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label>Photo</label>
                                        <input type="file" class="form-control-file" name="photo">

                                        @if($crop->photo)
                                            <div class="mt-3">
                                                <label>Current Photo:</label>
                                                <img src="{{ asset('storage/' . $crop->photo) }}" alt="Crop Photo"
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