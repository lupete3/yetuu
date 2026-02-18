@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('farmlabours.index') }}">Farm labour</a></div>
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
                            <form method="post" action="{{ route('farmlabours.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-header">
                                    <h4>{{ $viewData['title'] }}</h4>
                                    <div class="card-header-action">
                                        <a href="{{ route('farmlabours.index') }}" class="btn btn-icon icon-left btn-success">
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

                                    <!-- Full time work -->
                                    <div class="form-group">
                                        <label>Full time work</label>
                                        <input type="number" class="form-control" name="full_time_workers" value="{{ old('full_time_workers') }}" placeholder="Full time work">
                                        @error('full_time_workers')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Seasonal workers -->
                                    <div class="form-group">
                                        <label>Seasonal workers</label>
                                        <input type="number" class="form-control" name="seasonal_workers" value="{{ old('seasonal_workers') }}" placeholder="Seasonal workers">
                                        @error('seasonal_workers')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Part timer workers -->
                                    <div class="form-group">
                                        <label>Part timer workers</label>
                                        <input type="number" class="form-control" name="part_time_workers" value="{{ old('part_time_workers') }}" placeholder="Part timer workers">
                                        @error('part_time_workers')
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
