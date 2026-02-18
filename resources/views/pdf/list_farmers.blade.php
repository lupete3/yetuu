<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Farmers</title>

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
            max-width: 1000px;
            margin: 0 auto;
            padding: 0px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
            padding: 5px;
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
            padding: 1px;
            font-size: 8px;
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
        <div class="header">
            <!-- Logo de l'entreprise -->
            @if(isset($settings['logo']))
                <img src="{{ asset('logos/'.$settings['logo']) }}" alt="{{ $settings['app_name'] }}">
            @else
                <p style="font-size: 24px; font-weight: bold;">LOGO</p>
            @endif
            <h1>List of Farmers</h1>
        </div>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Farmer ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Country</th>
                        <th>State / Province</th>
                        <th>Territory</th>
                        <th>Locality</th>
                        <th>Village</th>
                        <th>Operational Site</th>
                        <th>Number of Family Members</th>
                        <th>Main Occupation</th>
                        <th>Level of Education</th>
                        <th>Civil Status</th>
                        <th>Association Name</th>
                        <th>Contact Number</th>
                        <th>Type Of Support/Activity</th>
                        <th>Join Date</th>
                        <th>Priority Crop</th>
                        <th>Mobile Money Number</th>
                        <th>Status</th>
                        <th>Identity Proof</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($farmers as $index => $farmer)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $farmer->farmer_id }}</td>
                            <td>{{ $farmer->first_name }}</td>
                            <td>{{ $farmer->last_name }}</td>
                            <td>{{ $farmer->date_of_birth ?? 'N/A' }}</td>
                            <td>{{ $farmer->gender ?? 'N/A' }}</td>
                            <td>{{ $farmer->country->name ?? 'N/A' }}</td>
                            <td>{{ $farmer->province->name ?? 'N/A' }}</td>
                            <td>{{ $farmer->territory->name ?? 'N/A' }}</td>
                            <td>{{ $farmer->groupement->name ?? 'N/A' }}</td>
                            <td>{{ $farmer->village ?? 'N/A' }}</td>
                            <td>{{ $farmer->operational_site ?? 'N/A' }}</td>
                            <td>{{ $farmer->number_of_family_members ?? 'N/A' }}</td>
                            <td>{{ $farmer->main_occupation ?? 'N/A' }}</td>
                            <td>{{ $farmer->level_of_education ?? 'N/A' }}</td>
                            <td>{{ $farmer->civil_status ?? 'N/A' }}</td>
                            <td>{{ $farmer->association_name ?? 'N/A' }}</td>
                            <td>{{ $farmer->contact_number }}</td>
                            <td>{{ $farmer->accompaniement->name ?? 'N/A' }}</td>
                            <td>{{ $farmer->join_date ?? 'N/A' }}</td>
                            <td>{{ $farmer->priority_culture ?? 'N/A' }}</td>
                            <td>{{ $farmer->account_number ?? 'N/A' }}</td>
                            <td>{{ $farmer->status == 1 ? 'Active' : 'Inactive' }}</td>

                            <td>
                                @switch($farmer->doc_type)
                                    @case('passport')
                                        <span>Passport</span>
                                        @break
                                    @case('voting_card_id')
                                        <span>Voting Card ID</span>
                                        @break
                                    @default
                                        <span>Driving Lisence</span>
                                        @break
                                @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="21" style="text-align: center;">No farmers available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
