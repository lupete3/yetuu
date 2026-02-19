@extends('layouts.backend')

@php
    use Carbon\Carbon;
@endphp

@section('content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <style>
        .card {
            border-radius: 15px;
        }

        .card h2,
        .card h3,
        .card h4 {
            font-weight: bold;
        }

        .d-flex .fas {
            font-size: 300%;
            margin-right: 20px;
        }

        .weather .fas {
            font-size: 200%;
            margin-right: 5px;
        }

        .card i {
            margin-top: 10px;
        }

        #map {
            width: 100%;
            height: 500px;
            border-radius: 15px;
        }

        @media (max-width: 768px) {
            #map {
                height: 300px;
                /* Hauteur pour tablettes */
            }
        }

        @media (max-width: 576px) {
            #map {
                height: 250px;
                /* Hauteur pour mobiles */
            }
        }
    </style>


    <div class="main-content">
        <section class="section">

            <!-- Titre du tableau de bord -->
            <div class="py-2">
                <div class="row align-items-center mb-4">
                    <div class="col-12 text-start">
                        <h1 class="display-6 text-success">Dashboard</h1>
                    </div>
                </div>

                <!-- Statistiques principales -->
                <div class="row g-3">
                    <!-- Farmers Today -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow border-0">
                            <div class="card-body d-flex align-items-center">
                                <!-- Icône à gauche -->
                                <div class="icon-container text-primary me-3">
                                    <i class="fas fa-users fa-3x"></i> <!-- Icône large -->
                                </div>
                                <!-- Texte à droite -->
                                <div>
                                    <h6 class="text-muted">Total Farmers </h6>
                                    <h3 class="text-success mb-1">{{ $farmers }}</h3>
                                    <p class="text-muted mb-0">+{{ $farmersToday }} today</p>
                                    <p class="text-muted mb-0">+{{ $farmersThisWeek }} this week</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Farmers Today -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow border-0">
                            <div class="card-body d-flex align-items-center">
                                <!-- Icône à gauche -->
                                <div class="icon-container text-primary me-3">
                                    <i class="fas fa-users fa-3x"></i> <!-- Icône large -->
                                </div>
                                <!-- Texte à droite -->
                                <div>
                                    <h6 class="text-muted">Tot Farmer Support</h6>
                                    <h3 class="text-success mb-1">{{ $farmersSupport }}</h3>
                                    <p class="text-muted mb-0">+{{ $farmersSupportToday }} today</p>
                                    <p class="text-muted mb-0">+{{ $farmersSupportThisWeek }} this week</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Farms Today -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow border-0">
                            <div class="card-body d-flex align-items-center">
                                <!-- Icône à gauche -->
                                <div class="icon-container text-success me-3">
                                    <i class="fas fa-seedling fa-3x"></i> <!-- Icône large -->
                                </div>
                                <!-- Texte à droite -->
                                <div>
                                    <h6 class="text-muted">Total Farms </h6>
                                    <h3 class="text-success mb-1">{{ $farmsCount }}</h3>
                                    <p class="text-muted mb-0">+{{ $farmsToday }} today</p>
                                    <p class="text-muted mb-0">+{{ $farmsThisWeek }} this week</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Field Visits -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card shadow border-0">
                            <div class="card-body d-flex align-items-center">
                                <!-- Icône à gauche -->
                                <div class="icon-container text-success me-3">
                                    <i class="fas fa-walking fa-3x"></i> <!-- Icône large -->
                                </div>
                                <!-- Texte à droite -->
                                <div>
                                    <h6 class="text-muted">Total Field Visits</h6>
                                    <h3 class="text-success mb-1">{{ $fieldVisitsCount }}</h3>
                                    <p class="text-muted mb-0">+{{ $fieldVisitToday }} today</p>
                                    <p class="text-muted mb-0">+{{ $fieldVisitThisWeek }} this week</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="card shadow border-0">
                            <div class="card-bod">
                                <div id="farmersChart"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card shadow border-0">
                            <div class="card-bod">
                                <div id="farmsChart"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card shadow border-0">
                            <div class="card-bod">
                                <div id="fieldVisitChart"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow border-0">
                            <div class="card-bod">
                                <div id="farmersAndFarmerSupport"></div>
                            </div>
                        </div>
                    </div>



                </div>

                <!-- Bloc Carte Mapbox -->
                <div class="row mt-2 mb-2">
                    <div class="col-12 card pb-2">
                        <h5 class="text-muted mb-4">Farm Locations on Map</h5>
                        <div id="map"></div>
                    </div>
                </div>

                <div class="row mt-2 weather">
                    <!-- Carte principale (Météo actuelle) -->
                    <div class="col-lg-4 col-md-6">
                        <div class="card text-center shadow-sm border-0" style="background-color: #28a745; color: white;">
                            <div class="card-body">
                                <h3 class="mb-1">
                                    {{ round($weather['main']['temp']) }}°C
                                </h3>
                                <p class="small mb-2">
                                    <strong>{{ ucfirst($weather['weather'][0]['description'] ?? 'N/A') }}</strong>
                                </p>
                                <img src="https://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon'] }}@2x.png"
                                    alt="Weather icon" class="weather-icon mb-2">
                                <p class="small">
                                    <i class="fas fa-map-marker-alt"></i> {{ $weather['name'] ?? 'Unknown' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Détails supplémentaires -->
                    <div class="col-lg-8 col-md-6">
                        <div class="row g-3">
                            <!-- Temperature -->
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="icon-container text-primary me-3">
                                            <i class="fas fa-thermometer-half fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="small text-muted mb-1">Temperature</p>
                                            <h5 class="text-success">{{ round($weather['main']['temp']) }}°C</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Humidity -->
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="icon-container text-info me-3">
                                            <i class="fas fa-tint fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="small text-muted mb-1">Humidity</p>
                                            <h5 class="text-success">{{ $weather['main']['humidity'] ?? 'N/A' }}%</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pressure -->
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="icon-container text-warning me-3">
                                            <i class="fas fa-compress-arrows-alt fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="small text-muted mb-1">Pressure</p>
                                            <h5 class="text-success">{{ $weather['main']['pressure'] ?? 'N/A' }} hPa</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Wind -->
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="icon-container text-secondary me-3">
                                            <i class="fas fa-wind fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="small text-muted mb-1">Wind</p>
                                            <h5 class="text-success">{{ $weather['wind']['speed'] ?? 'N/A' }} m/s</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Precipitation -->
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="icon-container text-primary me-3">
                                            <i class="fas fa-cloud-rain fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="small text-muted mb-1">Precipitation</p>
                                            <h5 class="text-success">{{ $weather['rain']['1h'] ?? '0' }} mm</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Cloud Coverage -->
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="icon-container text-dark me-3">
                                            <i class="fas fa-cloud fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="small text-muted mb-1">Cloud Coverage</p>
                                            <h5 class="text-success">{{ $weather['clouds']['all'] ?? 'N/A' }}%</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sunrise -->
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="icon-container text-warning me-3">
                                            <i class="fas fa-sun fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="small text-muted mb-1">Sunrise</p>
                                            <h5 class="text-success">
                                                {{
        Carbon::createFromTimestamp($weather['sys']['sunrise'])->format('H:i')
                                                }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sunset -->
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="card shadow-sm border-0">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="icon-container text-danger me-3">
                                            <i class="fas fa-moon fa-2x"></i>
                                        </div>
                                        <div>
                                            <p class="small text-muted mb-1">Sunset</p>
                                            <h5 class="text-success">
                                                {{
        \Carbon\Carbon::createFromTimestamp($weather['sys']['sunset'])->format('H:i')
                                                }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section>
    </div>

    <!-- Scripts Mapbox -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.js"></script>
    <script src="{{asset('assets/backend/modules/jquery.min.js')}}"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                series: [{
                    name: 'Farmers',
                    data: @json($farmersByMonth)
                }],
                annotations: {
                    points: [
                        {
                            x: 'July',
                            seriesIndex: 0,
                            label: {
                                borderColor: '#25C253',
                                offsetY: 0,
                                style: {
                                    color: '#fff',
                                    background: '#25C253',
                                },
                                text: '',
                            }
                        }
                    ]
                },
                chart: {
                    height: 250,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        columnWidth: '50%',
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 0
                },
                grid: {
                    row: {
                        colors: ['#fff', '#f2f2f2'],
                    }
                },
                xaxis: {
                    labels: {
                        rotate: -45
                    },
                    categories: @json($months),
                    tickPlacement: 'on'
                },
                yaxis: {
                    title: {
                        text: 'Number of Farmers',
                    },
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "horizontal",
                        shadeIntensity: 0.25,
                        gradientToColors: undefined,
                        inverseColors: true,
                        opacityFrom: 0.85,
                        opacityTo: 0.85,
                        stops: [50, 0, 100]
                    },
                },
                colors: ['#25C253'],
                title: {
                    text: 'Farmers Created Per Month',
                    align: 'center',
                    style: {
                        fontSize: '14px'
                    }
                }
            };

            var chart = new window.ApexCharts(document.querySelector("#farmersChart"), options);
            chart.render();
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var options = {
                series: [{
                    name: 'Saved Farms',
                    type: 'line',
                    data: @json($farmsByMonth)
                }],
                chart: {
                    height: 250,
                    type: 'line',
                },
                stroke: {
                    curve: 'smooth'
                },
                fill: {
                    type: 'solid',
                    opacity: [0.35, 1],
                },
                labels: @json($months),
                markers: {
                    size: 0
                },
                yaxis: [
                    {
                        opposite: true,
                        title: {
                            text: 'Saved Farms',
                        },
                    },
                ],
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function (y) {
                            if (typeof y !== "undefined") {
                                return y.toFixed(0) + " points";
                            }
                            return y;
                        }
                    }
                },
                colors: ['#0F9104']
            };


            var chart = new window.ApexCharts(document.querySelector("#farmsChart"), options);
            chart.render();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var options = {
                chart: {
                    type: 'area',
                    height: 300
                },
                series: [
                    { name: 'Field Visits', data: @json($fieldVisitsByMonth) },
                    { name: 'Farmer Support', data: @json($farmerSupportByMonth) },
                ],
                xaxis: {
                    categories: @json($months)
                },
                title: {
                    text: 'Field Visits And Farmer Support created per month',
                    align: 'center'
                },
                colors: ['#799E05', '#7DDE05']
            };

            var chart = new window.ApexCharts(document.querySelector("#fieldVisitChart"), options);
            chart.render();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            var options = {
                series: [{{ $farmersSupport }}, {{ $nonSupport }}],
                labels: ['Supported Farmers', 'Not supported'],
                chart: {
                    width: 380,
                    type: 'donut',
                },
                plotOptions: {
                    pie: {
                        startAngle: -90,
                        endAngle: 270
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return val.toFixed(1) + '%';
                    }
                },
                fill: {
                    type: 'gradient',
                },
                colors: ['#25C253', '#E1FFD6'],
                legend: {
                    position: 'bottom',
                    formatter: function (val, opts) {
                        return val + " - " + opts.w.globals.series[opts.seriesIndex];
                    }
                },
                title: {
                    text: 'Progress of Supported Farmers',
                    align: 'center'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 300
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            };


            var chart = new window.ApexCharts(document.querySelector("#farmersAndFarmerSupport"), options);
            chart.render();
        });
    </script>






    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if ('geolocation' in navigator) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    fetchWeather(lat, lon);
                }, (error) => {
                    console.error("Error getting location:", error);
                    // Fallback to default coordinates
                    fetchWeather(-2.5034752, 28.8555008);
                });
            } else {
                // Fallback if geolocation is not available
                fetchWeather(-2.5034752, 28.8555008);
            }
        });

        function fetchWeather(lat, lon) {
            console.log(`/agri-solution/api/weather?lat=${lat}&lon=${lon}`);

            fetch(`/agri-solution/api/weather?lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('temp').textContent = `${data.main.temp}°C`;
                        document.getElementById('weather-desc').textContent = `City: ${data.name}, Desc: ${data.weather[0].description}`;
                        const iconUrl = `https://openweathermap.org/img/wn/${data.weather[0].icon}@2x.png`;
                        const weatherIcon = document.getElementById('weather-icon');
                        weatherIcon.src = iconUrl;
                        weatherIcon.style.display = 'block';
                    } else {
                        document.getElementById('temp').textContent = 'N/A';
                        document.getElementById('weather-desc').textContent = 'Weather data unavailable';
                    }
                })
                .catch(error => {
                    console.error("Error fetching weather data:", error);
                    document.getElementById('temp').textContent = 'N/A';
                    document.getElementById('weather-desc').textContent = 'Error loading weather data';
                });
        }

        // Clé d'accès Mapbox
        mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';

        // Initialisation de la carte
        const map = new mapboxgl.Map({
            container: 'map', // ID du conteneur HTML
            style: 'mapbox://styles/mapbox/streets-v11', // Style de la carte
            center: [28.0339, 1.6596], // Centre par défaut (longitude, latitude)
            zoom: 5 // Niveau de zoom par défaut
        });

        // Données des fermes depuis le backend
        const farms = @json($farms);
        const bounds = new mapboxgl.LngLatBounds();

        // Ajout des marqueurs pour chaque ferme
        farms.forEach(farm => {
            if (farm.gps_location) {
                const coordinates = farm.gps_location.split(',').map(coord => parseFloat(coord.trim()));
                bounds.extend(coordinates);

                // Ajout du marqueur
                const marker = new mapboxgl.Marker()
                    .setLngLat(coordinates)
                    .addTo(map);

                // Création d'une popup
                const popup = new mapboxgl.Popup({ offset: 25 })
                    .setHTML(`
                    <h6>${farm.farm_name || 'Farm'}</h6>
                    <p><strong>Location:</strong> ${farm.gps_location}</p>
                    <p><strong>Owner:</strong> ${farm.farmer.first_name || 'N/A'} ${farm.farmer.last_name || 'N/A'}</p>
                    <p><strong>Land holding:</strong> ${farm.total_land_holding} ha</p>
                `);

                // Attachement de la popup au marqueur
                marker.setPopup(popup);

                // Affichage de la popup au survol
                marker.getElement().addEventListener('mouseenter', () => popup.addTo(map));
                marker.getElement().addEventListener('mouseleave', () => popup.remove());
            }
        });

        // Ajustement de la vue pour inclure toutes les fermes
        if (farms.length > 0) {
            map.fitBounds(bounds, { padding: 20, maxZoom: 15 });
        }

        // Réinitialisation de la carte lors du redimensionnement
        map.on('load', () => {
            window.addEventListener('resize', () => {
                map.resize();
            });
        });

    </script>

@endsection