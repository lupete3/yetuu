<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crop Profile</title>
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
                <img src="{{ asset('logos/' . $settings['logo']) }}" alt="{{ $settings['app_name'] }}" style="width: 20%;">
            @else
                <p>LOGO</p>
            @endif

            <h1>
                @if(isset($settings['app_name']))
                    {{ $settings['app_name'] }}
                @else
                    CROP MANAGEMENT
                @endif
            </h1>
            <h3>CROP PROFILE</h3>
        </div>

        <table class="info-table">
            <tr>
                <th>Farmer</th>
                <td colspan="3">{{ $crop->farmer->last_name . ' ' . $crop->farmer->first_name }}</td>
            </tr>
            <tr>
                <th>Growing Season</th>
                <td>{{ $crop->growing_season }}</td>
                <th>Crop Type</th>
                <td>{{ $crop->crop_type }}</td>
            </tr>
            <tr>
                <th>Crop ID</th>
                <td>{{ $crop->crop_id }}</td>
                <th>Sowing Date</th>
                <td>{{ $crop->planting_date ? \Carbon\Carbon::parse($crop->planting_date)->format('d/m/Y') : 'Not defined' }}
                </td>
            </tr>
            <tr>
                <th>Variety</th>
                <td>{{ $crop->variety_name ?? 'Not specified' }}</td>
                <th>Expected Harvest Date</th>
                <td>{{ $crop->harvest_date ? \Carbon\Carbon::parse($crop->harvest_date)->format('d/m/Y') : 'Not defined' }}
                </td>
            </tr>
            <tr>
                <th>Disease Resistance</th>
                <td>{{ $crop->disease_resistance ?? 'N/A' }}</td>
                <th>Growth Duration (days)</th>
                <td>{{ $crop->growth_duration ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Fertilizer Requirements</th>
                <td>{{ $crop->fertilizer_requirements ?? 'N/A' }}</td>
                <th>Growth Stage</th>
                <td>{{ $crop->growth_stage ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Photo</th>
                <td>
                    @if($crop->photo)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $crop->photo) }}" alt="Crop Photo" class="img-thumbnail"
                                width="100">
                        </div>
                    @endif
                </td>
                <th>Created At</th>
                <td>{{ $crop->created_at->format('d/m/Y') }}</td>

            </tr>
        </table>

        <div class="footer">
            <p>
                @if(isset($settings['phone']))
                    {{ $settings['phone'] }}
                @else
                    phone
                @endif
            </p>
            <p>
                @if(isset($settings['address']))
                    {{ $settings['address'] }}
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

</body>

</html>