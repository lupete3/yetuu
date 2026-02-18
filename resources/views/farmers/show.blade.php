
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
    <div class="header">
        @if(isset($settings['logo']))
            <img src="{{ asset('logos/'.$settings['logo']) }}" alt="{{ $settings['app_name'] }}" style="width: 20%;">
        @else
            LOGO
        @endif

        <h3>Farmer's Profile</h3>
    </div>

    <!-- Basic Information with Photo and QR Code -->
    <div class="section basic-info">
        <div class="photo">
            @if($farmer->photo)
                <img src="{{ asset('storage/app/public/' . $farmer->photo) }}" alt="Farmer Photo" width="100px" >
            @else
                <div class="photo-placeholder">PHOTO</div>
            @endif
        </div>

        <div class="details">
            <h2>Basic Information</h2>
            <div class="field"><label>Farmer ID:</label> <span>{{ $farmer->farmer_id }}</span></div>
            <div class="field"><label>Name:</label> <span>{{ $farmer->first_name }} {{ $farmer->last_name }}</span></div>
            <div class="field"><label>Date of Birth:</label> <span>{{ $farmer->date_of_birth }}</span></div>
            <div class="field"><label>Gender:</label> <span>{{ $farmer->gender }}</span></div>
            <div class="field"><label>Pnone:</label> <span>{{ $farmer->contact_number }}</span></div>
        </div>

        <div class="qrcode">
            @php
                $country = $farmer->country->name;
                $province = $farmer->province->name;
                $territory = $farmer->territory->name;
            @endphp
            {!! QrCode::size(100)->generate("
                Farmer ID: $farmer->farmer_id
                Name: $farmer->first_name $farmer->last_name
                Contact: $farmer->contact_number
                Country: $country
                State: $province
                Territory: $territory
                Village: $farmer->village
                Operational Site: $farmer->operational_site
            ") !!}
        </div>
    </div>


    <!-- Location Information -->
    <div class="section">
        <h2>Location Information</h2>
        <div class="field"><label>Country:</label> <span>{{ $farmer->country->name }}</span></div>
        <div class="field"><label>State/Province:</label> <span>{{ $farmer->province->name }}</span></div>
        <div class="field"><label>Territory:</label> <span>{{ $farmer->territory->name }}</span></div>
        <div class="field"><label>Locality:</label> <span>{{ $farmer->groupement?->name }}</span></div>
        <div class="field"><label>Village:</label> <span>{{ $farmer->village }}</span></div>
        <div class="field"><label>Operational Site:</label> <span>{{ $farmer->operational_site }}</span></div>
    </div>

    <!-- Family and Education Information -->
    <div class="section">
        <h2>Family and Education Information</h2>
        <div class="field"><label>Number of Family Members:</label> <span>{{ $farmer->number_of_family_members ?? 'N/A'}}</span></div>
        <div class="field"><label>Main Occupation:</label> <span>{{ $farmer->main_occupation ?? 'N/A'}}</span></div>
        <div class="field"><label>Level of Education:</label> <span>{{ $farmer->level_of_education ?? 'N/A'}}</span></div>
        <div class="field"><label>Civil Status:</label> <span>{{ $farmer->civil_status ?? 'N/A'}}</span></div>
    </div>

    <!-- Association Information -->
    <div class="section">
        <h2>Association Information</h2>
        <div class="field"><label>Member of Association:</label> <span>{{ $farmer->is_member_of_association ? 'Yes' : 'No' }}</span></div>
        <div class="field"><label>Association Name:</label> <span>{{ $farmer->association_name ?? 'N/A' }}</span></div>
    </div>

    <!-- Bank Information -->
    <div class="section">
        <h2>Mobile Money Information</h2>
        <div class="field"><label>Mobile Money Operator:</label> <span>{{ $farmer->bank_name ?? 'N/A' }}</span></div>
        <div class="field"><label>Account Number:</label> <span>{{ $farmer->account_number ?? 'N/A'}}</span></div>
    </div>

    <!-- Bank Information -->
    <div class="section">
        <h2>Other Informations</h2>
        <div class="field"><label>Type Of Support:</label> <span>{{ $farmer->accompaniement->name ?? 'N/A'}}</span></div>
        <div class="field"><label>Join Date:</label> <span>{{ $farmer->join_date ?? 'N/A'}}</span></div>
        <div class="field"><label>Priority Crop:</label> <span>{{ $farmer->priority_culture ?? 'N/A'}}</span></div>
        <div class="field"><label>Status:</label> <span>{{ $farmer->status == 1 ? 'Active' : 'Inactive' }}</span></div>
    </div>

    <!-- Association Information -->
    <div class="section">
        <h2>Identity Proof</h2>
        <div class="field"><label>Type Of ID:</label>

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

        </div>
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


