@extends('layouts.backend')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>All Land Plots on Map</h1>
            </div>

            <div class="section-body">
                <div id='map' style='width: 100%; height: 500px;'></div>
            </div>
        </section>
    </div>

    <script src="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.js"></script>

    <script>
        mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [28.0339, 1.6596],
            zoom: 5
        });

        const fields = @json($fields);

        fields.forEach((field) => {
            if (field.formatted_coordinates) {
                const coordinates = field.formatted_coordinates;

                // Ajout du polygone pour chaque champ
                map.on('load', () => {
                    map.addSource(`field-${field.id}`, {
                        'type': 'geojson',
                        'data': {
                            'type': 'Feature',
                            'geometry': {
                                'type': 'Polygon',
                                'coordinates': coordinates
                            }
                        }
                    });

                    map.addLayer({
                        'id': `field-layer-${field.id}`,
                        'type': 'fill',
                        'source': `field-${field.id}`,
                        'layout': {},
                        'paint': {
                            'fill-color': '#088',
                            'fill-opacity': 0.5
                        }
                    });

                    // Ajout du popup
                    const popup = new mapboxgl.Popup({ offset: 25 })
                        .setHTML(`<h4>${field.field_name || 'Leand Plot'}</h4>
                                  <p><strong>Location:</strong> ${field.gps_location}</p>
                                  <p><strong>Owner:</strong> ${field.farmer.first_name || 'N/A'} ${field.farmer.last_name || 'N/A'}</p>
                                  <p><strong>Size:</strong> ${field.total_area} hectares</p>`);

                    // Ajout d'un événement clic pour afficher le popup
                    map.on('click', `field-layer-${field.id}`, (e) => {
                        popup.setLngLat(e.lngLat).addTo(map);
                    });

                    // Changement du curseur sur le survol du polygone
                    map.on('mouseenter', `field-layer-${field.id}`, () => {
                        map.getCanvas().style.cursor = 'pointer';
                    });
                    map.on('mouseleave', `field-layer-${field.id}`, () => {
                        map.getCanvas().style.cursor = '';
                    });
                });
            }
        });
    </script>
@endsection