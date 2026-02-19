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
                            <div class="card-header">
                                <h4>{{ $viewData['title'] }}</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('farmconversions.create') }}"
                                        class="btn btn-icon icon-left btn-success">
                                        <i class="fas fa-plus"></i> Add
                                    </a>
                                    <a href="{{ route('farmconversions.export_excel') }}"
                                        class="btn btn-icon icon-left btn-success">
                                        <i class="fas fa-download"></i> Export to Excel
                                    </a>
                                    <a href="{{ route('farmconversions.print') }}"
                                        class="btn btn-icon icon-left btn-success">
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
                                                <th>Farm Name</th>
                                                <th>Last Date Chemical Applied</th>
                                                <th>Estimated Yield (in tons)</th>
                                                <th>Conventional Lands</th>
                                                <th>Conventional Crops</th>
                                                <th>Inspector Name</th>
                                                <th>Qualified Inspector</th>
                                                <th>Date of Inspection</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($viewData['farms_conversions'] as $farmconversion)
                                                <tr>
                                                    <td>{{ $farmconversion->id }}</td>
                                                    <td>{{ $farmconversion->farm->farm_name }}</td>
                                                    <td>{{ $farmconversion->last_date_chemical_applied }}</td>
                                                    <td>{{ $farmconversion->estimated_yield }}</td>
                                                    <td>{{ $farmconversion->conventional_lands }}</td>
                                                    <td>{{ $farmconversion->conventional_crops }}</td>
                                                    <td>{{ $farmconversion->inspector_name }}</td>
                                                    <td>{{ $farmconversion->qualified_inspector ? 'Yes' : 'No' }}</td>
                                                    <td>{{ $farmconversion->date_of_inspection }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a href="#" class="dropdown-toggle btn btn-success"
                                                                data-toggle="dropdown">Action</a>
                                                            <div class="dropdown-menu dropdown-menu-right">
                                                                <a target="_blank"
                                                                    href="{{ route('farmconversions.show', $farmconversion->id) }}"
                                                                    class="dropdown-item has-icon">
                                                                    <i class="far fa-eye text-info"></i> View
                                                                </a>
                                                                <a href="{{ route('farmconversions.edit', $farmconversion->id) }}"
                                                                    class="dropdown-item has-icon">
                                                                    <i class="far fa-edit text-success"></i> Edit
                                                                </a>

                                                                <form
                                                                    action="{{ route('farmconversions.destroy', $farmconversion->id) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item has-icon"
                                                                        onclick="return confirm('Are you sure you want to delete this farm labour?');">
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
                                    {{ $viewData['farms_conversions']->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection