<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Farm Profile</title>

    <link href="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            max-width: 150px;
        }

        .header h1 {
            color: #228B22;
            margin: 10px 0;
        }

        .header h3 {
            color: #555;
            margin: 5px 0;
        }

        .section-title {
            background-color: #8FBC8F;
            color: white;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
            text-align: left;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .info-table,
        .info-table th,
        .info-table td {
            border: 1px solid #ddd;
        }

        .info-table th,
        .info-table td {
            padding: 8px;
            text-align: left;
        }

        .info-table th {
            background-color: #e0f7da;
        }

        .photo-section {
            text-align: center;
            vertical-align: middle;
        }

        .photo-placeholder {
            width: 120px;
            height: 120px;
            background-color: #e9e9e9;
            color: #aaa;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 10px auto;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #555;
        }

        .print-button {
            display: block;
            width: 100px;
            margin: 0 auto 20px;
            padding: 10px;
            background-color: #228B22;
            color: white;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .print-button:hover {
            background-color: #196F3D;
        }

        /* Hide the print button when printing */
        @media print {
            .print-button {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            @if(isset($settings['logo']))
                <img src="{{ asset('public/logos/' . $settings['logo']) }}" alt="{{ $settings['app_name'] }}"
                    style="width: 20%">
            @else
                LOGO
            @endif

            <h1>
                @if(isset($settings['app_name']))
                    {{ $settings['app_name'] }}
                @else
                    FARMS MANAGEMENT
                @endif
            </h1>
            <h3>FARM PROFILE</h3>
        </div>

        <table class="info-table">
            <tr>
                <th colspan="4" class="photo-section">
                    @if($farm->photo)
                        <img src="{{ asset('storage/app/public/' . $farm->photo) }}" alt="Farm Photo"
                            style="max-width: 100px;">
                    @else
                        <div class="photo-placeholder">PHOTO</div>
                    @endif
                </th>
            </tr>
            <tr>
                <th>Farm ID</th>
                <td>{{ $farm->farm_id }}</td>
                <th>Farm Name</th>
                <td>{{ $farm->farm_name }}</td>
            </tr>
            <tr>
                <th>Farmer</th>
                <td>{{ $farm->farmer->first_name }} {{ $farm->farmer->last_name }}</td>
                <th>Registration Date</th>
                <td>{{ $farm->registration_date }}</td>
            </tr>
            <tr>
                <th>Previous Cultivated Crop</th>
                <td>{{ $farm->previous_cultivated_crop ?? 'N/A' }}</td>
                <th>Land Topography</th>
                <td>{{ $farm->land_topography }}</td>
            </tr>
            <tr>
                <th>Proposed Planting Area (ha)</th>
                <td>{{ $farm->proposed_planting_area }}</td>
                <th>Total Land Holding (ha)</th>
                <td>{{ $farm->total_land_holding }}</td>
            </tr>
            <tr>
                <th>Land Ownership</th>
                <td>{{ ucfirst($farm->land_ownership) }}</td>
                <th>Nearby</th>
                <td>{{ $farm->nearby ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>GPS Location</th>
                <td colspan="3">{{ $farm->gps_location }}</td>
            </tr>
            <tr>
                <th>Address</th>
                <td colspan="3">{{ $farm->address }}</td>
            </tr>
        </table>

        <div class="footer">
            <div id="map"
                style="width: 100%; height: 300px; margin-top: 20px; border: 1px solid #ddd; border-radius: 8px;"></div>

            <p>
                @if(isset($settings['phone']))
                    {{ $settings['phone'] }}
                @else
                    phone
                @endif
            </p>
            <p>
                @if(isset($settings['adress']))
                    {{ $settings['adress'] }}
                @else
                    address
                @endif
            </p>
            <p>Email:
                @if(isset($settings['email']))
                    {{ $settings['email'] }}
                @else
                    email
                @endif
            </p>

            <button class="print-button" onclick="window.print()">Print</button>
        </div>
    </div>

    <script src="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.js"></script>

    <script>
        mapboxgl.accessToken = '{{ config('services.mapbox.token') }}';

        const initialCoordinates = "{{ $farm->gps_location }}" ?
            "{{ $farm->gps_location }}".split(',').map(coord => parseFloat(coord.trim())) :
            [28.0339, 1.6596];

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: initialCoordinates,
            zoom: 12
        });

        new mapboxgl.Marker()
            .setLngLat(initialCoordinates)
            .addTo(map);
    </script>

</body>

</html>