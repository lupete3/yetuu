<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Management Report</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 0;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f8f8;
            border-top: 2px solid #4CAF50;
            border-bottom: 2px solid #4CAF50;
        }

        .header img {
            width: 100px;
            margin-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #4CAF50;
            font-size: 20px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content th,
        .content td {
            border: 1px solid #ddd;
            padding: 5px;
            font-size: 10px;
            text-align: left;
        }

        .content th {
            background-color: #4CAF50;
            color: #fff;
        }

        .content tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer p {
            font-size: 12px;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            @if(isset($settings['logo']))
                <img src="{{ asset('logos/' . $settings['logo']) }}" alt="{{ $settings['app_name'] }}">
            @else
                <p style="font-size: 24px; font-weight: bold;">LOGO</p>
            @endif
            <h1>Crop Management Report</h1>
        </div>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Crop ID</th>
                        <th>Farmer</th>
                        <th>Growing Season</th>
                        <th>Crop Type</th>
                        <th>Variety</th>
                        <th>Sowing Date</th>
                        <th>Harvest Date</th>
                        <th>Growth Stage</th>
                        <th>Disease Resistance</th>
                        <th>Growth Duration (days)</th>
                        <th>Fertilizer Requirements</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($crop_managements as $index => $crop)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $crop->crop_id }}</td>
                            <td>{{ $crop->farmer->last_name . ' ' . $crop->farmer->first_name }}</td>
                            <td>{{ $crop->growing_season }}</td>
                            <td>{{ $crop->crop_type }}</td>
                            <td>{{ $crop->variety_name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($crop->planting_date)->format('d/m/Y') }}</td>
                            <td>{{ $crop->harvest_date ? \Carbon\Carbon::parse($crop->harvest_date)->format('d/m/Y') : 'Not defined' }}
                            </td>
                            <td>{{ $crop->growth_stage ?? 'N/A' }}</td>
                            <td>{{ $crop->disease_resistance ?? 'N/A' }}</td>
                            <td>{{ $crop->growth_duration ?? 'N/A' }}</td>
                            <td>{{ $crop->fertilizer_requirements ?? 'N/A' }}</td>
                            <td>{{ $crop->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" style="text-align: center;">No crops available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p>Generated on {{ now()->format('d/m/Y') }}</p>
            @if(isset($settings['phone']))
                <p>Contact: {{ $settings['phone'] }}</p>
            @endif
            @if(isset($settings['addresse']))
                <p>Address: {{ $settings['addresse'] }}</p>
            @endif
        </div>
    </div>
</body>

</html>