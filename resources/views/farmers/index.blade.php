@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('farmers.index') }}">Farmers</a></div>
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
                                    <a href="{{ route('farmers.create') }}" class="btn btn-icon icon-left btn-success">
                                        <i class="fas fa-plus"></i> Add
                                    </a>
                                    <a href="{{ route('farmers.export_excel') }}" class="btn btn-icon icon-left btn-success">
                                        <i class="fas fa-download"></i> Export to Excel
                                    </a>
                                    <a href="{{ route('farmers.print') }}" class="btn btn-icon icon-left btn-success">
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
                                                <th>Farmer ID</th> <!-- Ajout du farmer_id ici -->
                                                <th>Photo</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Date of Birth</th>
                                                <th>Gender</th>
                                                <th>Country</th>
                                                <th>State/Province</th>
                                                <th>Territory</th>
                                                <th>Locality</th>
                                                <th>Village</th>
                                                <th>Operational Site</th>
                                                <th>Family Members</th>
                                                <th>Contact Number</th>
                                                <th>Created At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($viewData['farmers'] as $farmer)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $farmer->farmer_id }}</td> <!-- Affichage du farmer_id -->
                                                    <td>
                                                        @if($farmer->photo)
                                                            <img src="{{ asset('storage/' . $farmer->photo) }}" alt="Farmer Photo" width="50">
                                                        @else
                                                            Not defined
                                                        @endif
                                                    </td>
                                                    <td>{{ $farmer->first_name }}</td>
                                                    <td>{{ $farmer->last_name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($farmer->date_of_birth)->format('d/m/Y') }}</td>
                                                    <td>{{ ucfirst($farmer->gender) }}</td>
                                                    <td>{{ $farmer->country->name }}</td>
                                                    <td>{{ $farmer->province->name }}</td>
                                                    <td>{{ $farmer->territory->name }}</td>
                                                    <td>{{ $farmer->groupement?->name }}</td>
                                                    <td>{{ $farmer->village }}</td>
                                                    <td>{{ $farmer->operational_site }}</td>
                                                    <td>{{ $farmer->number_of_family_members }}</td>
                                                    <td>{{ $farmer->contact_number }}</td>
                                                    <td>{{ $farmer->created_at->format('d/m/Y') }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle btn btn-success" data-toggle="dropdown">Action</a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a target="_blank" href="{{ route('farmers.show', $farmer->id) }}" class="dropdown-item has-icon">
                                                                    <i class="far fa-eye text-info"></i> View
                                                                </a>
                                                                <a href="{{ route('farmers.edit', $farmer->id) }}" class="dropdown-item has-icon">
                                                                    <i class="far fa-edit text-success"></i> Edit
                                                                </a>

                                                                <form action="{{ route('farmers.destroy', $farmer->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item has-icon" onclick="return confirm('Are you sure you want to delete this farmer?');">
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
