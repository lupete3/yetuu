@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('farms.index') }}">Farms</a></div>
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
                                    <a href="{{ route('farms.create') }}" class="btn btn-icon icon-left btn-success">
                                        <i class="fas fa-plus"></i> Add 
                                    </a>
                                    <a href="{{ route('farms.map') }}" class="btn btn-icon icon-left btn-success">
                                        <i class="fas fa-map"></i> View All Farms on Map
                                    </a>
                                    <a href="{{ route('farms.export_excel') }}" class="btn btn-icon icon-left btn-success">
                                        <i class="fas fa-download"></i> Export to Excel
                                    </a>
                                    <a href="{{ route('farms.print') }}" class="btn btn-icon icon-left btn-success">
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
                                                <th>Farm ID</th>
                                                <th>Farm Name</th>
                                                <th>Farmer</th>
                                                <th>GPS Location</th>
                                                <th>Proposed Planting Area (ha)</th>
                                                <th>Total Land Holding (ha)</th>
                                                <th>Land Ownership</th>
                                                <th>Documents</th>
                                                <th>Registration Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($viewData['farms'] as $farm)
                                                <tr>
                                                    <td>{{ $farm->id }}</td>
                                                    <td>{{ $farm->farm_id }}</td>
                                                    <td>{{ $farm->farm_name }}</td>
                                                    <td>{{ $farm->farmer->first_name }} {{ $farm->farmer->last_name }}</td>
                                                    <td>{{ $farm->gps_location ?? 'N/A' }}</td>
                                                    <td>{{ $farm->proposed_planting_area }} hectares</td>
                                                    <td>{{ $farm->total_land_holding }} hectares</td>
                                                    <td>{{ ucfirst($farm->land_ownership) }}</td>
                                                    <td>
                                                        @if ($farm->documents_upload)
                                                            <ul>
                                                                @foreach ($farm->documents_upload as $document)
                                                                    <li>
                                                                        <a href="{{ asset('storage/' . $document['path']) }}" target="_blank">{{ $document['filename'] }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            No documents available
                                                        @endif
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($farm->registration_date)->format('d/m/Y') }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle btn btn-success" data-toggle="dropdown">Action</a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a target="_blank" href="{{ route('farms.show', $farm->id) }}" class="dropdown-item has-icon">
                                                                    <i class="far fa-eye text-info"></i> View
                                                                </a>
                                                                <a href="{{ route('farms.edit', $farm->id) }}" class="dropdown-item has-icon">
                                                                    <i class="far fa-edit text-success"></i> Edit
                                                                </a>

                                                                <form action="{{ route('farms.destroy', $farm->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item has-icon" onclick="return confirm('Are you sure you want to delete this farm?');">
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
                                <div class="mt-4">
                                    {{ $viewData['farms']->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection
