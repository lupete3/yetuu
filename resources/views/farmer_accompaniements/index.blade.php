@extends('layouts.backend')

@section('content')

    <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ $viewData['title'] }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('farmer-accompaniements.index') }}">Farmer Support</a></div>
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
                            <div class="card-header row">
                                <form method="GET" action="{{ route('farmer-accompaniements.index') }}" class="form-inline col-md-7">
                                    <h4>Filter By : </h4>
                                    <div class="form-group ">
                                        <label class="mr-2">Year</label>
                                        <select name="year" class="form-control mr-2" onchange="this.form.submit()">
                                            <option value="">Select Year</option>
                                            @for ($year = now()->year; $year >= now()->year - 10; $year--)
                                                <option value="{{ $year }}" {{ $viewData['selectedYear'] == $year ? 'selected' : '' }}>
                                                    {{ $year }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="form-group mr-2">
                                        <label class="mr-2">Season</label>
                                        <select name="filter_type" class="form-control mr-2" onchange="this.form.submit()">
                                            <option value="">Select a season</option>
                                            <option value="A" {{ $viewData['filterSeason'] === 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ $viewData['filterSeason'] === 'B' ? 'selected' : '' }}>B</option>
                                        </select>
                                    </div>
                                    <div class="form-group mr-2">
                                        <label class="mr-2">Select Type Of Support/Activity</label>
                                        <select name="typeSupport" class="form-control mr-2" onchange="this.form.submit()">
                                            <option value="">Select Type Of Support/Activity</option>
                                            @foreach($viewData['accompaniements'] as $accompaniement)
                                                <option value="{{ $accompaniement->id }}">
                                                    {{ $accompaniement->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mr-2">
                                        <label class="mr-2">Select Country</label>
                                        <select name="country" class="form-control mr-2" onchange="this.form.submit()">
                                            <option value="">Select Country</option>
                                            @foreach($viewData['countries'] as $country)
                                                <option value="{{ $country->name }}">
                                                    {{ $country->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>


                                </form>
                                <div class="card-header-action align-items-end col-md-5">


                                    <a href="{{ route('farmer-accompaniements.create') }}" class="btn btn-icon icon-left btn-success">
                                        <i class="fas fa-plus"></i> Add
                                    </a>
                                    <a href="{{ route('farmaccompaniement.export-excel') }}?filter_type={{ $viewData['filterSeason'] }}&year={{ $viewData['selectedYear'] }}" class="btn btn-icon icon-left btn-success">
                                        <i class="fas fa-download"></i> Export to Excel
                                    </a>
                                    <a href="{{ route('farmer-accompaniements.generate_pdf') }}?filter_type={{ $viewData['filterSeason'] }}&year={{ $viewData['selectedYear'] }}" class="btn btn-icon icon-left btn-success">
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
                                                <th>Year</th>
                                                <th>Season</th>
                                                <th>Beneficiary Name</th>
                                                <th>Age</th>
                                                <th>Gender</th>
                                                <th>Phone Number</th>
                                                <th>Country</th>
                                                <th>Province/State</th>
                                                <th>Territory</th>
                                                <th>Groupement</th>
                                                <th>Village</th>
                                                <th>Operational Site</th>
                                                <th>GPS Coordinates</th>
                                                <th>Crop Sown</th>
                                                <th>Variety</th>
                                                <th>Seed Quantity Received (Kg)</th>
                                                <th>Fertilizer Type</th>
                                                <th>Basal Fertilizer Quantity Received (Kg)</th>
                                                <th>Top-dressing Fertilizer Quantity Received (Kg)</th>
                                                <th>Superficial Area Cultivated</th>
                                                <th>Training Sessions Received</th>
                                                <th>Types of Training Received</th>
                                                <th>Additional Support Received</th>
                                                <th>Quantity Produced (Kg)</th>
                                                <th>Quantity Reimbursed (Kg)</th>
                                                <th>Type Of Support/Activities</th>
                                                <th>Observations</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($viewData['farmerAccompaniements'] as $farmer)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $farmer->year }}</td>
                                                    <td>{{ $farmer->season }}</td>
                                                    <td>{{ $farmer->beneficiary_name }}</td>
                                                    <td>{{ $farmer->age }}</td>
                                                    <td>{{ ucfirst($farmer->gender) }}</td>
                                                    <td>{{ $farmer->phone_number }}</td>
                                                    <td>{{ $farmer->country }}</td>
                                                    <td>{{ $farmer->province }}</td>
                                                    <td>{{ $farmer->territory }}</td>
                                                    <td>{{ $farmer->groupement }}</td>
                                                    <td>{{ $farmer->village }}</td>
                                                    <td>{{ $farmer->site }}</td>
                                                    <td>{{ $farmer->gps_coordinates }}</td>
                                                    <td>{{ $farmer->crop_sown }}</td>
                                                    <td>{{ $farmer->variety }}</td>
                                                    <td>{{ $farmer->seed_quantity_received }}</td>
                                                    <td>{{ $farmer->fertilizer_type }}</td>
                                                    <td>{{ $farmer->fertilizer_quantity_base }}</td>
                                                    <td>{{ $farmer->fertilizer_quantity_surface }}</td>
                                                    <td>{{ $farmer->cultivated_area }}</td>
                                                    <td>{{ $farmer->training_sessions_received }}</td>
                                                    <td>{{ $farmer->training_types_received }}</td>
                                                    <td>{{ $farmer->additional_support_received }}</td>
                                                    <td>{{ $farmer->quantity_produced }}</td>
                                                    <td>{{ $farmer->quantity_reimbursed }}</td>
                                                    <td>{{ $farmer->accompaniement->name }}</td>

                                                    <td>{{ $farmer->observations }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle btn btn-success" data-toggle="dropdown">Action</a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a target="_blank" href="{{ route('farmer-accompaniements.show', $farmer->id) }}" class="dropdown-item has-icon">
                                                                    <i class="far fa-eye text-info"></i> View
                                                                </a>
                                                                <a href="{{ route('farmer-accompaniements.edit', $farmer->id) }}" class="dropdown-item has-icon">
                                                                    <i class="far fa-edit text-success"></i> Edit
                                                                </a>
                                                                <form action="{{ route('farmer-accompaniements.destroy', $farmer->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item has-icon" onclick="return confirm('Are you sure you want to delete this record?');">
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
