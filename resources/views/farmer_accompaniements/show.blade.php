@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Farmer's Profile Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; }
        .container { width: 100%; max-width: 700px; margin: 0 auto; padding-left:20px; border: 1px solid #ddd; }
        .header {
            text-align: center;
        }
        .header img {
            max-width: 150px;
        }
        .header h1 {
            color: #228B22;
            margin: 8px 0;
        }
        h2 { border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-top: 10px; }
        .section { margin-bottom: 20px; }
        .field { margin-bottom: 10px; }
        .field label { font-weight: bold; display: inline-block; width: 200px; }
        .field span { display: inline-block; }
        .basic-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .basic-info .photo, .basic-info .qrcode {
            flex: 1;
            text-align: center;
        }
        .basic-info .details {
            flex: 2;
        }
        .photo-placeholder, .qrcode img {
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin: 0 auto;
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
            .print-button { display: none; }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header -->
    <div class="header">
        @if(isset($settings['logo']))
            <img src="{{ asset('public/logos/'.$settings['logo']) }}" alt="{{ $settings['app_name'] }}" style="width: 20%;">
        @else
            LOGO
        @endif

        <h3>Farmer's Support Report</h3>
    </div>

    <!-- Basic Information with Photo and QR Code -->
    <div class="section basic-info">

        <div class="details">
            <h2>Basic Information</h2>
            <div class="field"><label>Beneficiary Name:</label> <span>{{ $farmerAccompaniement->beneficiary_name }}</span></div>
            <div class="field"><label>Age:</label> <span>{{ $farmerAccompaniement->age }}</span></div>
            <div class="field"><label>Gender:</label> <span>{{ $farmerAccompaniement->gender }}</span></div>
            <div class="field"><label>Phone Number:</label> <span>{{ $farmerAccompaniement->phone_number }}</span></div>
        </div>

        <div class="qrcode">
            @php
                $country = $farmerAccompaniement->country;
                $province = $farmerAccompaniement->province;
                $territory = $farmerAccompaniement->territory;
            @endphp
            {!! QrCode::size(100)->generate("
                Beneficiary Name: $farmerAccompaniement->beneficiary_name
                Age: $farmerAccompaniement->age
                Gender: $farmerAccompaniement->gender
                Country: $country
                Province: $province
                Territory: $territory
                Village: $farmerAccompaniement->village
                Operational Site: $farmerAccompaniement->site
            ") !!}
        </div>
    </div>

    <!-- Location Information -->
    <div class="section">
        <h2>Location Information</h2>
        <div class="field"><label>Country:</label> <span>{{ $farmerAccompaniement->country }}</span></div>
        <div class="field"><label>Province/State:</label> <span>{{ $farmerAccompaniement->province }}</span></div>
        <div class="field"><label>Territory:</label> <span>{{ $farmerAccompaniement->territory }}</span></div>
        <div class="field"><label>Village:</label> <span>{{ $farmerAccompaniement->village }}</span></div>
        <div class="field"><label>Operational Site:</label> <span>{{ $farmerAccompaniement->site }}</span></div>
    </div>

    <!-- Crop Information -->
    <div class="section">
        <h2>Crop Information</h2>
        <div class="field"><label>Year:</label> <span>{{ $farmerAccompaniement->year ?? 'N/A' }}</span></div>
        <div class="field"><label>Season:</label> <span>{{ $farmerAccompaniement->season ?? 'N/A' }}</span></div>
        <div class="field"><label>Crop Sown:</label> <span>{{ $farmerAccompaniement->crop_sown ?? 'N/A' }}</span></div>
        <div class="field"><label>Variety:</label> <span>{{ $farmerAccompaniement->variety ?? 'N/A' }}</span></div>
        <div class="field"><label>Seed Quantity Received (Kg):</label> <span>{{ $farmerAccompaniement->seed_quantity_received ?? 'N/A' }}</span></div>
        <div class="field"><label>Fertilizer Type:</label> <span>{{ $farmerAccompaniement->fertilizer_type ?? 'N/A' }}</span></div>
        <div class="field"><label>Basal Quantity Fertilizer Received (Kg):</label> <span>{{ $farmerAccompaniement->fertilizer_quantity_base ?? 'N/A' }}</span></div>
        <div class="field"><label>Top-dressing Quantity Fertilizer Received (Kg):</label> <span>{{ $farmerAccompaniement->fertilizer_quantity_surface ?? 'N/A' }}</span></div>
        <div class="field"><label>Superficial Area Cultivated:</label> <span>{{ $farmerAccompaniement->cultivated_area ?? 'N/A' }}</span></div>
    </div>

    <!-- Training and Support Information -->
    <div class="section">
        <h2>Training and Support Information</h2>
        <div class="field"><label>Training Sessions Received:</label> <span>{{ $farmerAccompaniement->training_sessions_received ?? 'N/A' }}</span></div>
        <div class="field"><label>Types of Training Received:</label> <span>{{ $farmerAccompaniement->training_types_received ?? 'N/A' }}</span></div>
        <div class="field"><label>Additional Support Received:</label> <span>{{ $farmerAccompaniement->additional_support_received ?? 'N/A' }}</span></div>
    </div>

    <!-- Production Information -->
    <div class="section">
        <h2>Production Information</h2>
        <div class="field"><label>Quantity Produced (Kg):</label> <span>{{ $farmerAccompaniement->quantity_produced ?? 'N/A' }}</span></div>
        <div class="field"><label>Quantity Reimbursed (Kg):</label> <span>{{ $farmerAccompaniement->quantity_reimbursed ?? 'N/A' }}</span></div>
    </div>
    <!-- Footer -->
    <div class="footer">
        <p>{{ $settings['phone'] ?? 'Phone' }} <br>
        {{ $settings['address'] ?? 'Address' }} <br>
        Email: {{ $settings['email'] ?? 'Email' }}</p>
        <button class="print-button" onclick="window.print()">Print</button>
    </div>

</div>

</body>
</html>
