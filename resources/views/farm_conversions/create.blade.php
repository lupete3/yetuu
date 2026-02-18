@extends('layouts.backend')

@section('content')
    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('farmconversions.index') }}">Farm Conversion Info</a></div>
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
                            <form method="post" action="{{ route('farmconversions.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4>{{ $viewData['title'] }}</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('farmconversions.index') }}" class="btn btn-icon icon-left btn-success">
                                            <i class="fas fa-list-alt"></i> View
                                        </a>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <!-- Farm Selection -->
                                    <div class="form-group">
                                        <label>Farm</label>
                                        <select class="form-control form-control-sm select2" data-show-subtext="true" data-live-search="true"  name="farm_id">
                                            <option value="">Select Farm</option>
                                            @foreach($viewData['farms'] as $farm)
                                                <option value="{{ $farm->id }}" {{ old('farm_id') == $farm->id ? 'selected' : '' }}>
                                                    {{ $farm->farm_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('farm_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Last Date Chemical Applied -->
                                    <div class="form-group">
                                        <label>Last Date Chemical Applied</label>
                                        <input type="date" class="form-control" name="last_date_chemical_applied" value="{{ old('last_date_chemical_applied') }}">
                                        @error('last_date_chemical_applied')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Estimated Yield -->
                                    <div class="form-group">
                                        <label>Estimated Yield (in tons)</label>
                                        <input type="number" step="0.01" class="form-control" name="estimated_yield" value="{{ old('estimated_yield') }}" placeholder="Estimated Yield">
                                        @error('estimated_yield')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Conventional Lands -->
                                    <div class="form-group">
                                        <label>Conventional Lands</label>
                                        <input type="text" class="form-control" name="conventional_lands" value="{{ old('conventional_lands') }}" placeholder="Conventional Lands">
                                        @error('conventional_lands')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Conventional Crops -->
                                    <div class="form-group">
                                        <label>Conventional Crops</label>
                                        <input type="text" class="form-control" name="conventional_crops" value="{{ old('conventional_crops') }}" placeholder="Conventional Crops">
                                        @error('conventional_crops')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Inspector Name -->
                                    <div class="form-group">
                                        <label>Inspector Name</label>
                                        <input type="text" class="form-control" name="inspector_name" value="{{ old('inspector_name') }}" placeholder="Inspector Name">
                                        @error('inspector_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Qualified Inspector -->
                                    <div class="form-group">
                                        <label>Qualified Inspector</label>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="qualified_inspector" value="1" {{ old('qualified_inspector') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="qualified_inspector">Yes</label>
                                        </div>

                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" name="qualified_inspector" value="0" {{ old('qualified_inspector') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="qualified_inspector">No</label>
                                        </div>
                                        @error('qualified_inspector')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Date of Inspection -->
                                    <div class="form-group">
                                        <label>Date of Inspection</label>
                                        <input type="date" class="form-control" name="date_of_inspection" value="{{ old('date_of_inspection') }}">
                                        @error('date_of_inspection')
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
@endsection
