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
                <div class="col-12">
                    @if($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible" id="msg" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h6>{{ $error }}</h6>
                            </div>
                        @endforeach
                    @endif

                    @if(Session::has('success'))
                        <div class="alert alert-success alert-dismissible" id="msg" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h6>{{ Session::get('success') }}</h6>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h4>{{ $viewData['title'] }}</h4>
                            <div class="card-header-action">
                                <a href="{{ route('crop-management.create') }}" class="btn btn-icon icon-left btn-success">
                                    <i class="fas fa-plus"></i> Add
                                </a>
                                <a href="{{ route('crop-management.export_excel') }}" class="btn btn-icon icon-left btn-success">
                                    <i class="fas fa-download"></i> Export to Excel
                                </a>
                                <a href="{{ route('crop-management.print') }}" class="btn btn-icon icon-left btn-success">
                                    <i class="fas fa-print"></i> Export to PDF
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Crop ID</th>
                                            <th>Farmer</th>
                                            <th>Growing Season</th>
                                            <th>Crop Type</th>
                                            <th>Variety</th>
                                            <th>Disease Resistance</th>
                                            <th>Growth Duration (days)</th>
                                            <th>Fertilizer Requirements</th>
                                            <th>Sowing Date</th>
                                            <th>Harvest Date</th>
                                            <th>Growth Stage</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($viewData['crops'] as $index => $crop)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $crop->crop_id }}</td>
                                                <td>{{ $crop->farmer->first_name }} {{ $crop->farmer->last_name }}</td>
                                                <td>{{ $crop->growing_season }}</td>
                                                <td>{{ $crop->crop_type }}</td>
                                                <td>{{ $crop->variety_name ?? 'N/A' }}</td>
                                                <td>{{ $crop->disease_resistance ?? 'N/A' }}</td>
                                                <td>{{ $crop->growth_duration ?? 'N/A' }}</td>
                                                <td>{{ $crop->fertilizer_requirements ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($crop->planting_date)->format('d/m/Y') }}</td>
                                                <td>{{ $crop->harvest_date ? \Carbon\Carbon::parse($crop->harvest_date)->format('d/m/Y') : 'Not defined' }}</td>
                                                <td>{{ $crop->growth_stage ?? 'N/A' }}</td>
                                                <td>{{ $crop->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle btn btn-success" data-toggle="dropdown">Action</a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a target="_blank" href="{{ route('crop-management.show', $crop->id) }}" class="dropdown-item has-icon">
                                                                <i class="far fa-eye text-info"></i> View
                                                            </a>
                                                            <a href="{{ route('crop-management.edit', $crop->id) }}" class="dropdown-item has-icon">
                                                                <i class="far fa-edit text-success"></i> Edit
                                                            </a>

                                                            <form action="{{ route('crop-management.destroy', $crop->id) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item has-icon" onclick="return confirm('Are you sure you want to delete this crop?');">
                                                                    <i class="fas fa-trash text-danger"></i> Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
