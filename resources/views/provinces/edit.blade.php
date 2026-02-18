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
                <div class="col-12 col-md-12 col-lg-12">
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
                        <form method="post" action="{{ route('provinces.update', $province->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>{{ $viewData['title'] }}</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('provinces.index') }}" class="btn btn-icon icon-left btn-success">
                                        <i class="fas fa-list-alt"></i> View
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="form-group">
                                    <label>Province Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $province->name }}" required>
                                </div>

                                <div class="form-group">
                                    <label>Country</label>
                                    <select class="form-control form-control-sm select2" data-show-subtext="true" data-live-search="true"  name="country_id" required>
                                        @foreach($viewData['countries'] as $country)
                                            <option value="{{ $country->id }}" {{ $country->id == $province->country_id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
