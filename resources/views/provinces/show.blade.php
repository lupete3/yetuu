<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Farmers' Profile</title>
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
                <img src="{{ asset('logos/' . $settings['logo']) }}" alt="{{ $settings['app_name'] }}" style="width: 20%">
            @else LOGO
            @endif

            <h1>
                @if(isset($settings['app_name']))
                    {{ $settings['app_name'] }}
                @else
                    FARMERS MANAGEMENT
                @endif
            </h1>
            <h3>FARMERS' PROFILE</h3>
        </div>

        <div class="section-title">PART I: UNIQUE INFORMATION</div>
        <table class="info-table">
            <tr>
                <th colspan="4" class="photo-section">
                    @if($farmer->photo)
                        <img src="{{ asset('storage/app/public/' . $farmer->photo) }}" alt="Farmer Photo"
                            style="max-width: 100px;">
                    @else
                        <div class="photo-placeholder">PHOTO</div>
                    @endif
                </th>
            </tr>
            <tr>
                <th>Last Name</th>
                <td>{{ $farmer->last_name }}</td>
                <th>First Name</th>
                <td>{{ $farmer->first_name }}</td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td>{{ $farmer->date_of_birth }}</td>
                <th>Gender</th>
                <td>{{ $farmer->gender }}</td>
            </tr>
            <tr>
                <th>Country</th>
                <td>{{ $farmer->country }}</td>
                <th>Province</th>
                <td>{{ $farmer->state_province }}</td>
            </tr>
            <tr>
                <th>Territory</th>
                <td>{{ $farmer->territory }}</td>
                <th>Village</th>
                <td>{{ $farmer->village }}</td>
            </tr>
            <tr>
                <th>Operational Site</th>
                <td colspan="3">{{ $farmer->operational_site }}</td>
            </tr>
            <tr>
                <th>Number of Family Members</th>
                <td>{{ $farmer->number_of_family_members }}</td>
                <th>Phone Number</th>
                <td>{{ $farmer->contact_number }}</td>
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

</body>

</html>