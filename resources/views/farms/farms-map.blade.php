@extends('layouts.backend')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>All Farms on Map</h1>
            </div>

            <div class="section-body">
                <div id='map' style='width: 100%; height: 500px;'></div>
            </div>
        </section>
    </div>

    <script src="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.js"></script>

    <script>
        mapboxgl.accessToken = '{{ config('services.mapbox.token') }}'; // Remplacez par votre clé API Mapbox

        // Initialisation de la carte
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [28.0339, 1.6596], // Coordonnées de centre par défaut (long, lat)
            zoom: 5
        });

        // Tableau des fermes récupéré depuis le contrôleur
        const farms = @json($farms);

        // Initialisation des limites de la carte
        const bounds = new mapboxgl.LngLatBounds();

        // Ajout des marqueurs pour chaque ferme
        farms.forEach((farm) => {
            if (farm.gps_location) {
                const coordinates = farm.gps_location.split(',').map(coord => parseFloat(coord.trim()));

                // Étendre les limites pour inclure cette ferme
                bounds.extend(coordinates);

                // Création d'un marqueur
                const marker = new mapboxgl.Marker()
                    .setLngLat(coordinates)
                    .addTo(map);

                // Ajout d'un popup sur le marqueur avec les détails de la ferme
                const popup = new mapboxgl.Popup({ offset: 25 })
                    .setHTML(`<h4>${farm.farm_name || 'Farm'}</h4>
                              <p><strong>Location:</strong> ${farm.gps_location}</p>
                              <p><strong>Owner:</strong> ${farm.farmer.first_name || 'N/A'} ${farm.farmer.last_name || 'N/A'}</p>
                              <p><strong>Size:</strong> ${farm.size} (in acres/hectares)</p>`);

                marker.setPopup(popup);

                // Afficher le popup au survol
                marker.getElement().addEventListener('mouseenter', () => popup.addTo(map));
                marker.getElement().addEventListener('mouseleave', () => popup.remove());
            }
        });

        // Ajuster le zoom pour inclure toutes les fermes
        if (farms.length > 0) {
            map.fitBounds(bounds, {
                padding: 20, // Espace autour des points (en pixels)
                maxZoom: 15, // Zoom maximum pour éviter d’être trop rapproché
            });
        }
    </script>

@endsection