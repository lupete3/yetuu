<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Farmer Accompaniments</title>

    <style>
        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            margin: 0 auto;
            padding: 0px;
        }
        .header, .footer {
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
        .content {
            margin-bottom: 20px;
        }
        .content table {
            width: 100%;
            border-collapse: collapse;
        }
        .content th, .content td {
            border: 1px solid #ddd;
            padding: 2px;
            font-size: 6px;
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
        .print-button {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
        }
        .print-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <!-- Logo de l'entreprise -->
            @if(isset($settings['logo']))
                <img src="{{ asset('public/logos/'.$settings['logo']) }}" alt="{{ $settings['app_name'] }}">
            @else
                <p style="font-size: 24px; font-weight: bold;">LOGO</p>
            @endif
            <h1>List of Farmer Accompaniments</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Year</th>
                        <th>Season</th>
                        <th>Beneficiary Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Country</th>
                        <th>Province/State</th>
                        <th>Territory</th>
                        <th>Groupement</th>
                        <th>Village</th>
                        <th>Operational Site</th>
                        <th>Phone Number</th>
                        <th>GPS Coordinates</th>
                        <th>Crop Sown</th>
                        <th>Variety</th>
                        <th>Seed Quantity Received (Kg)</th>
                        <th>Fertilizer Type</th>
                        <th>Basal Fertilizer Quantity Received (Kg)</th>
                        <th>Top-dressing Fertilizer Quantity Received (Kg)</th>
                        <th>Superficial Area Cultivated</th>
                        <th>Training Sessions Received</th>
                        <th>Types of Training Received</th>
                        <th>Additional Support Received</th>
                        <th>Quantity Produced (Kg)</th>
                        <th>Quantity Reimbursed (Kg)</th>
                        <th>Type Of Support/Activity</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($farmerAccompaniements as $index => $farmerAccompaniement)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $farmerAccompaniement->year ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->season ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->beneficiary_name ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->age ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->gender ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->country ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->province ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->territory ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->groupement ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->village ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->site ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->phone_number ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->gps_coordinates ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->crop_sown ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->variety ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->seed_quantity_received ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->fertilizer_type ?? 'N/A' }}</td>
                            <td>{{ $farmer->fertilizer_quantity_base ?? 'N/A' }}</td>
                            <td>{{ $farmer->fertilizer_quantity_surface ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->cultivated_area ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->training_sessions_received ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->training_types_received ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->additional_support_received ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->quantity_produced ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->quantity_reimbursed ?? 'N/A' }}</td>
                            <td>{{ $farmerAccompaniement->accompaniement->name ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="24" style="text-align: center;">No farmer accompaniments available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>{{ $settings['phone'] ?? 'Phone' }} | {{ $settings['address'] ?? 'Address' }} | Email: {{ $settings['email'] ?? 'Email' }}</p>
        </div>
    </div>
</body>
</html>
