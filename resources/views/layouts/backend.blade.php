<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ $viewData['title'] }}</title>

  <!-- Bootstrap Select -->
  <link rel="stylesheet" href="{{asset('assets/backend/bootstrap-select/dist/css/bootstrap.min.css ')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/bootstrap-select/dist/css/bootstrap-select.min.css ')}}">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/backend/modules/bootstrap/css/bootstrap.min.css ')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/modules/fontawesome/css/all.min.css ')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('assets/backend/modules/jqvmap/dist/jqvmap.min.css ')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/modules/weather-icon/css/weather-icons.min.css ')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/modules/weather-icon/css/weather-icons-wind.min.css ')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/modules/summernote/summernote-bs4.css ')}}">

  <link rel="stylesheet" href="{{asset('assets/backend/modules/datatables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/backend/css/style.css ')}}">
  <link rel="stylesheet" href="{{asset('assets/backend/css/components.css ')}}">
  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{asset('assets/backend/modules/ionicons/css/ionicons.min.css ')}}">

  <link rel="stylesheet" href="{{asset('assets/backend/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css ')}}">

  <!-- Bootstrap-Iconpicker -->
<link rel="stylesheet" href="{{asset('assets/backend/modules/bootstrap-iconpicker/dist/css/bootstrap-iconpicker.min.css ')}}"/>


<!-- CSS Libraries -->
<link rel="stylesheet" href="{{asset('assets/backend/modules/bootstrap-daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="{{asset('assets/backend/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/backend/modules/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/backend/modules/jquery-selectric/selectric.css')}}">
<link rel="stylesheet" href="{{asset('assets/backend/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/backend/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">

<!-- Template CSS -->
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="assets/css/components.css">

<link href="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.6.0/mapbox-gl.js"></script>


<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>

@vite(['resources/js/app.js'])

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA -->

<style>
    /* Arrière-plan de la barre de navigation */
    .navbar {
        background-color: #4CAF50; /* Vert */
    }

    /* Couleur des icônes des liens actifs */
    a {
        color: #4CAF50; /* Vert */
    }

    /* Couleur des icônes des liens actifs */
    li a {
        color: #4CAF50; /* Vert */
    }

    /* Couleur des icônes des liens actifs */
    .sidebar-menu i{
        color: #4CAF50; /* Vert */
    }

    /* Couleur des icônes des liens actifs */
    .sidebar-menu .nav-link li {
        color: #4CAF50; /* Vert */
    }

    /* Couleur des icônes des liens lors du survol */
    .sidebar-menu .nav-link:hover i {
        color: #4CAF50; /* Vert */
    }

    /* Couleur des icônes des liens actifs dans le menu déroulant */
    .sidebar-menu .dropdown-menu .active a {
        color: #4CAF50; /* Vert */
    }

</style>

</head>

<body>

  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <nav class="navbar navbar-expand-md main-navbar valider" style="margin-left: -7px; margin-right: -0px">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
          <div class="search-element">

          </div>
        </form>
        <ul class="navbar-nav navbar-right">

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{asset('assets/backend/img/avatar/avatar-1.png ')}}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{ Auth::user()->name }}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-title">Connected</div>
              <a href="{{route('profile.edit')}}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <div class="dropdown-divider"></div>

              <!-- Authentication -->
              <form method="POST" action="{{ route('logout') }}">
                @csrf

                <a href="{{route('logout')}}" class="dropdown-item has-icon text-danger"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </form>
            </div>
          </li>
        </ul>
      </nav>

      @include('layouts.partials.aside')

      @yield('content')

      <footer class="main-footer valider">
        <div class="footer-left">
          Copyright &copy; {{ date('Y') }} <div class="bullet"></div> <a href="pdevtuto.com" target="__blank">
            <!-- Exemple pour afficher le nom de l'application -->
            @if(isset($settings['app_name']))
                {{ $settings['app_name'] }}
                @else Farmers Management
            @endif
        </a>
        </div>
        <div class="footer-right">

        </div>
      </footer>

    </div>
  </div>

  <style>
    li i{
      font-size: 20px;
    }
  </style>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/forms-advanced-forms.js"></script>

  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>

  <!-- General JS Scripts -->
  <script src="{{asset('assets/backend/modules/jquery.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/popper.js')}}"></script>
  <script src="{{asset('assets/backend/modules/tooltip.js')}}"></script>
  <script src="{{asset('assets/backend/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/moment.min.js')}}"></script>
  <script src="{{asset('assets/backend/js/stisla.js')}}"></script>
  <script src="{{asset('assets/backend/js/bundle.js')}}"></script>


  <!-- JS Libraies -->
  <script src="{{asset('assets/backend/modules/simple-weather/jquery.simpleWeather.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/chart.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/jqvmap/dist/jquery.vmap.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
  <script src="{{asset('assets/backend/modules/summernote/summernote-bs4.js')}}"></script>
  <script src="{{asset('assets/backend/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

  <!-- JS Libraies -->
  <script src="{{asset('assets/backend/modules/datatables/datatables.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/jquery-ui/jquery-ui.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/upload-preview/assets/js/jquery.uploadPreview.min.js ')}}"></script>

  <script src="{{asset('assets/backend/modules/cleave-js/dist/cleave.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/cleave-js/dist/addons/cleave-phone.us.js')}}"></script>
  <script src="{{asset('assets/backend/modules/jquery-pwstrength/jquery.pwstrength.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{asset('assets/backend/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/select2/dist/js/select2.full.min.js')}}"></script>
  <script src="{{asset('assets/backend/modules/jquery-selectric/jquery.selectric.min.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{asset('assets/backend/js/page/modules-datatables.js')}}"></script>
  <script src="{{asset('assets/backend/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('assets/backend/modules/upload-preview/assets/js/jquery.uploadPreview.min.js ')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{asset('assets/backend/js/page/index-0.js')}}"></script>

  <!-- Template JS File -->
  <script src="{{asset('assets/backend/js/scripts.js')}}"></script>
  <script src="{{asset('assets/backend/js/custom.js')}}"></script>


  <script>
    $(document).ready(function(){
        $('.print').on('click',function(){
            $('.valider').hide();
            if (!window.print()) {
                $('.valider').show();
            };
        });
    });
  </script>


</body>
</html>
