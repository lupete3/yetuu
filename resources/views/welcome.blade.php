@extends('layouts.backend')

@php
    use Carbon\Carbon;
@endphp

@section('content')

<style>
    .card {
    border-radius: 15px;
}

.card h2, .card h3, .card h4 {
    font-weight: bold;
}

.card i {
    margin-top: 10px;
}

</style>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        
        <div class="py-4">
            <div class="row align-items-center mb-4">
                <!-- Titre principal -->
                <div class="col-12 text-start">
                    <h1 class="display-6 text-success">Dashboard</h1>
                    <p class="text-muted">Welcome back! Here's an overview of your agricultural system.</p>
                </div>
            </div>

            <div class="row g-3">

                <!-- Carte d'évolution des agriculteurs -->
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center shadow border-0">
                        <div class="card-body">
                            <h5 class="text-muted">Farmers Today</h5>
                            <h2 class="text-success">{{ $farmersToday }}</h2>
                            <p class="small text-muted">+{{ $farmersThisWeek }} this week</p>
                        </div>
                    </div>
                </div>

                <!-- Carte d'évolution des fermes -->
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center shadow border-0">
                        <div class="card-body">
                            <h5 class="text-muted">Farms Today</h5>
                            <h2 class="text-success">{{ $farmsToday }}</h2>
                            <p class="small text-muted">+{{ $farmsThisWeek }} this week</p>
                        </div>
                    </div>
                </div>

                <!-- Carte état des cultures -->
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center shadow border-0">
                        <div class="card-body">
                            <h5 class="text-muted">Your Fields</h5>
                            <h3 class="text-success">{{ $viewData['crops_count'] }}</h3>
                            <p class="small text-muted">crops</p>
                        </div>
                    </div>
                </div>

                <!-- Carte état des cultures -->
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center shadow border-0">
                        <div class="card-body">
                            <h5 class="text-muted">Field Visits</h5>
                            <h3 class="text-success">{{ $viewData['field_visits_count'] }}</h3>
                            <p class="small text-muted">max</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte météo -->
                
            @if(isset($weather))
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center shadow border-0">
                        <div class="card-body">
                            <h3 class="text-success mb-1">
                                {{ $weather['main']['temp'] ?? 'N/A' }}°C
                            </h3>
                            <p class="text-muted small">
                                {{ 'City: ' . ($weather['name'] ?? 'Unknown') . ', Desc: ' . ($weather['weather'][0]['description'] ?? 'N/A') }}
                            </p>
                            <img 
                                src="https://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] ?? '01d' }}@2x.png" 
                                alt="Weather icon" 
                                class="weather-icon"
                            >
                        </div>
                    </div>
                </div>

                <!-- Lignes supplémentaires -->
                <div class="col-lg-8 col-md-6">
                    <div class="row g-3 mt-4">
                        <!-- Carte Vent -->
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="card text-center shadow-sm border-0">
                                <div class="card-body">
                                    <p class="small text-muted mb-1">Wind</p>
                                    <h4 class="text-success">{{ $weather['wind']['speed'] ?? 'N/A' }} m/s</h4>
                                </div>
                            </div>
                        </div>
    
                        <!-- Carte Température -->
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="card text-center shadow-sm border-0">
                                <div class="card-body">
                                    <p class="small text-muted mb-1">Temperature</p>
                                    <h4 class="text-success">{{ $weather['main']['temp'] ?? 'N/A' }}°C</h4>
                                </div>
                            </div>
                        </div>
    
                        <!-- Carte Humidité -->
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="card text-center shadow-sm border-0">
                                <div class="card-body">
                                    <p class="small text-muted mb-1">Humidity</p>
                                    <h4 class="text-success">{{ $weather['main']['humidity'] ?? 'N/A' }}%</h4>
                                </div>
                            </div>
                        </div>
    
                        <!-- Carte Sol -->
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="card text-center shadow-sm border-0">
                                <div class="card-body">
                                    <p class="small text-muted mb-1">Soil Moisture</p>
                                    <h4 class="text-success">65%</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
                <p>Search weather's data</p>
            @endif

        </div>

        <!-- Filter Form -->
        {{-- <form method="GET" action="{{ route('dashboard') }}">
            <div class="row">
                <div class="col-md-3">
                    <label for="date_filter">Filter by:</label>
                    <select name="date_filter" id="date_filter" class="form-control">
                        <option value="daily" {{ request('date_filter') == 'daily' ? 'selected' : '' }}>Daily</option>
                        <option value="weekly" {{ request('date_filter') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                        <option value="monthly" {{ request('date_filter') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                        <option value="yearly" {{ request('date_filter') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="start_date">Start Date:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date', \Carbon\Carbon::today()->toDateString()) }}">
                </div>
                <div class="col-md-2">
                    <label for="end_date">End Date:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date', \Carbon\Carbon::today()->toDateString()) }}">
                </div>
                <div class="col-md-2">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-success btn-block">Apply</button>
                </div>
            </div>
        </form> --}}

        {{-- <div class="row mt-4">
            <!-- Farmers -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="ion-ios-person"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Farmers</h4>
                        </div>
                        <div class="card-body">
                            {{ $viewData['farmers_count'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Farms -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="ion-ios-home"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Farms</h4>
                        </div>
                        <div class="card-body">
                            {{ $viewData['farms_count'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Crops -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="ion-leaf"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Crops</h4>
                        </div>
                        <div class="card-body">
                            {{ $viewData['crops_count'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Field Visits -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="ion-ios-calendar"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Field Visits</h4>
                        </div>
                        <div class="card-body">
                            {{ $viewData['field_visits_count'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Climate Data -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-dark">
                        <i class="ion-ios-sunny"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Climate Data</h4>
                        </div>
                        <div class="card-body">
                            {{ $viewData['climates_count'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alerts -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="ion-alert-circled"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Alerts</h4>
                        </div>
                        <div class="card-body">
                            {{ $viewData['alerts_count'] }}
                        </div>
                    </div>
                </div>
            </div>

            @if (Auth::user()->role == 'super-admin')

            <!-- Risk Assessments -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="ion-android-alert"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Risk Assessments</h4>
                        </div>
                        <div class="card-body">
                            {{ $viewData['risk_assessments_count'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advisories -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="ion-ios-help"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Advisories</h4>
                        </div>
                        <div class="card-body">
                            {{ $viewData['advisories_count'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Regions -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-info">
                        <i class="ion-ios-location"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Regions</h4>
                        </div>
                        <div class="card-body">
                            {{ $viewData['regions_count'] }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payments -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="ion-cash"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Payments</h4>
                        </div>
                        <div class="card-body">
                            {{ $viewData['total_payments'] }}
                            @if(isset($settings['currency']))
                                {{ $settings['currency'] }}
                            @else
                                CDF
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions -->
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="ion-arrow-swap"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Transactions</h4>
                        </div>
                        <div class="card-body">
                            {{ $viewData['total_transactions'] }}
                            @if(isset($settings['currency']))
                                {{ $settings['currency'] }}
                            @else
                                CDF
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @endif

        </div> --}}

    </section>
</div>

@endsection

<style>
    .card-icon i {
        font-size: 20px;
        color: white;
        font-size: 30px;
    }
    .card-icon {
        padding-top: 25px;
    }
    .card-header h4 {
        font-size: 16px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        if ('geolocation' in navigator) {
            navigator.geolocation.getCurrentPosition((position) => {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                window.location.href = `?lat=${lat}&lon=${lon}`;
            }, (error) => {
                console.error("Erreur lors de l'obtention de la localisation :", error);
            });
        }
    });
</script>