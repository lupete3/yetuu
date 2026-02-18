<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings['app_name'] }}</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{asset('assets/backend/modules/bootstrap/css/bootstrap.min.css ')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/modules/fontawesome/css/all.min.css ')}}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{asset('assets/backend/modules/jqvmap/dist/jqvmap.min.css ')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/modules/weather-icon/css/weather-icons.min.css ')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/modules/weather-icon/css/weather-icons-wind.min.css ')}}">
    <link rel="stylesheet" href="{{asset('assets/backend/modules/summernote/summernote-bs4.css ')}}">

    <link rel="stylesheet" href="{{asset('assets/backend/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
        href="{{asset('assets/backend/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet"
        href="{{asset('assets/backend/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <style>
        body {
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
            overflow: hidden;
        }

        .login-container {
            min-height: 100vh;
            background-color: #fff;
        }

        .login-image {
            background: url('{{ asset("logos/login.png") }}') no-repeat center center/cover;
            min-height: 10vh;
        }

        .form-logo {
            max-width: 120px;
            margin-bottom: 1px;
        }
    </style>
</head>

<body>

    @yield('content')

    <!-- General JS Scripts -->
    <script src="{{asset('assets/backend/modules/jquery.min.js')}}"></script>
    <script src="{{asset('assets/backend/modules/popper.js')}}"></script>
    <script src="{{asset('assets/backend/modules/tooltip.js')}}"></script>
    <script src="{{asset('assets/backend/modules/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/backend/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
    <script src="{{asset('assets/backend/modules/moment.min.js')}}"></script>
    <script src="{{asset('assets/backend/js/stisla.js')}}"></script>
    <script src="{{asset('assets/backend/js/bundle.js')}}"></script>

    <!-- Template JS File -->
    <script src="{{asset('assets/backend/js/scripts.js')}}"></script>
    <script src="{{asset('assets/backend/js/custom.js')}}"></script>

</body>

</html>