<!-- resources/views/settings/index.blade.php -->
@extends('layouts.backend')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Paramètre d'application</h1>
            </div>

            <div class="section-body">
                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="app_name">Nom Organisation</label>
                        <input type="text" name="app_name" id="app_name" class="form-control"
                            value="{{ $settings['app_name'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="phone">Telephone</label>
                        <input type="text" name="phone" id="phone" class="form-control"
                            value="{{ $settings['phone'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control"
                            value="{{ $settings['email'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="adress">Adresse</label>
                        <input type="text" name="adress" id="adress" class="form-control"
                            value="{{ $settings['adress'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="currency">Devise</label>
                        <input type="text" name="currency" id="currency" class="form-control"
                            value="{{ $settings['currency'] ?? '' }}">
                    </div>
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" name="logo" id="logo" class="form-control">
                        @if(isset($settings['logo']))
                            <img src="{{ asset('logos/' . $settings['logo']) }}" alt="Logo" style="max-width: 100px;">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Mettre à jour les paramètres</button>
                </form>
            </div>
        </section>
    </div>
@endsection