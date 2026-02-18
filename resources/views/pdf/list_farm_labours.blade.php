<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Farm labours</title>

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

        .header,
        .footer {
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

        .content th,
        .content td {
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
                <img src="{{ asset('logos/' . $settings['logo']) }}" alt="{{ $settings['app_name'] }}">
            @else
                <p style="font-size: 24px; font-weight: bold;">LOGO</p>
            @endif
            <h1>List of Farm Labours</h1>
        </div>

        <div class="content">
            <table>
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Farm Name</th>
                        <th>Full time works</th>
                        <th>Seasonal works</th>
                        <th>Part time works</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($farm_labours as $index => $farmlabour)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $farmlabour->farm->farm_name }}</td>
                            <td>{{ $farmlabour->full_time_workers }}</td>
                            <td>{{ $farmlabour->seasonal_workers }}</td>
                            <td>{{ $farmlabour->part_time_workers }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center;">No farm labours available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>