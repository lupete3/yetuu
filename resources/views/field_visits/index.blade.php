@extends('layouts.backend')

@section('content')

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ $viewData['title'] }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('field_visits.index') }}">Land visits</a></div>
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
                                <a href="{{ route('field_visits.create') }}" class="btn btn-icon icon-left btn-success">
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
                                            <th>Staff field</th>
                                            <th>Land</th>
                                            <th>Visit date</th>
                                            <th>Estimated yield</th>
                                            <th>GPS</th>
                                            <th>Notes</th>
                                            <th>Photos</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($viewData['field_visits'] as $visit)
                                            <tr>
                                                <td>{{ $visit->id }}</td>
                                                <td>{{ $visit->user->name }}</td>
                                                <td>{{ $visit->field->farmer->last_name.' '.$visit->field->farmer->first_name.' ('.$visit->field->field_name.')' ?? 'N/A' }}</td>
                                                <td>{{ $visit->visit_date }}</td>
                                                <td>{{ $visit->estimated_yield ?? 'N/A' }}</td>
                                                <td>{{ $visit->gps_location ?? 'N/A' }}</td>
                                                <td>{{ Str::limit($visit->notes, 50, '...') }}</td>
                                                <td>
                                                    @foreach(json_decode($visit->photos) as $photo)
                                                        <a href="{{ asset('storage/app/public/'.$photo) }}" target="_blank">
                                                            <img src="{{ asset('storage/app/public/'.$photo) }}" width="50" height="50" class="img-thumbnail" alt="Photo">
                                                        </a>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a href="#" class="dropdown-toggle btn btn-success" data-toggle="dropdown">Action</a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <a href="{{ route('field_visits.show', $visit->id) }}" class="dropdown-item has-icon">
                                                                <i class="far fa-eye text-info"></i> View
                                                            </a>
                                                            <a href="{{ route('field_visits.edit', $visit->id) }}" class="dropdown-item has-icon">
                                                                <i class="far fa-edit text-success"></i> Edit
                                                            </a>

                                                            <form action="{{ route('field_visits.destroy', $visit->id) }}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="dropdown-item has-icon" onclick="return confirm('Do you want to delete this information ?');">
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
