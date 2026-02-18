@extends('layouts.backend')

@section('content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $viewData['title'] }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('provinces.index') }}">Provinces</a></div>
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
                                <a href="{{ route('provinces.create') }}" class="btn btn-icon icon-left btn-success">
                                    <i class="fas fa-plus"></i> Add 
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Province Name</th>
                                            <th>Country</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($viewData['provinces'] as $province)
                                            <tr>
                                                <td>{{ $province->id }}</td>
                                                <td>{{ $province->name }}</td>
                                                <td>{{ $province->country->name }}</td>
                                                <td>{{ $province->created_at->format('d/m/Y') }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle btn btn-success" data-toggle="dropdown">Action</a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            {{-- <a target="_blank" href="{{ route('provinces.show', $province->id) }}" class="dropdown-item has-icon">
                                                                <i class="far fa-eye text-info"></i> View
                                                            </a> --}}
                                                            <a href="{{ route('provinces.edit', $province->id) }}" class="dropdown-item has-icon">
                                                                <i class="far fa-edit text-success"></i> Edit
                                                            </a>

                                                            <form action="{{ route('provinces.destroy', $province->id) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item has-icon" onclick="return confirm('Are you sure you want to delete this province?');">
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
