<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ config('app.name', 'Reports') }}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">




  <!-- For Bootstrap Modal -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Popper JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- ... -->

        <!-- Favicons -->
        <link href="{{asset('v3/assets/img/favicon.png')}}" rel="icon">
        <link href="{{ asset('v3/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

        <!-- cdn for js tables -->
        <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
          <!-- Google Fonts -->
          <link href="https://fonts.gstatic.com" rel="preconnect">
          <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

          <!-- Vendor CSS Files -->
          <link href="{{ asset('v3/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
          <link href="{{ asset('v3/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
          <link href="{{ asset('v3/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
          <link href="{{ asset('v3/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
          <link href="{{ asset('v3/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
          <link href="{{ asset('v3/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
          <link href="{{ asset('v3/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

          <!-- Template Main CSS File -->
          <link href="{{ asset('v3/assets/css/style.css') }}" rel="stylesheet">

          {{-- For forms --}}
          {{-- <link rel="stylesheet" href="{{ asset('css/form-steps.css') }}"> --}}

          {{-- For the sweetalert--}}
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


          <!-- For Charts -->
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

          <!-- Sweet Alert -->
          <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.6/dist/sweetalert2.min.css" rel="stylesheet">
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.6/dist/sweetalert2.all.min.js"></script>

</head>
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center bg-info">

    <div class="d-flex align-items-center justify-content-between">
      <div class="ml-5">
        <img src="/images/logo.png" alt="" style="height: 50px;">
      </div>
    </div><!-- End Logo -->


    <i class="bi bi-list toggle-sidebar-btn m-5 p-5"></i>

    <nav class="header-nav ms-auto">

      <div class="dropdown">
        <button class="btn btn-light btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{Session::get('name')}}
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <!-- Other dropdown items can go here -->

            <!-- Logout form -->
            <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
      </div>
    </nav><!-- End Icons Navigation -->

  </header>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar bg-info">

        <ul class="sidebar-nav" id="sidebar-nav" style="">
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route ('dashboard')}}">
                <i class="bi bi-bar-chart-fill px-3"></i>
                <span>Dashboard</span>
                </a>
            </li>

            @foreach($modules as $module)
                <li class="nav-item">
                    @if ($module->submodules->isNotEmpty())
                        <a class="nav-link collapsed" data-bs-toggle="collapse" href="#module-{{ $module->id }}">
                            <i class="bi {{ $module->icon ?? 'bi-circle' }} px-3"></i>
                            <span>{{ $module->name }}</span>
                            <i class="bi bi-chevron-down ms-auto"></i>
                        </a>
                        <ul id="module-{{ $module->id }}" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                            @foreach($module->submodules as $submodule)
                                <li>
                                    <a class="nav-link collapsed" href="{{ url($submodule->url ?? '#') }}">
                                        <i class="bi {{ $submodule->icon ?? 'bi-dot' }}"></i>
                                        <span>{{ $submodule->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <a class="nav-link collapsed" href="{{ url($module->url ?? '#') }}">
                            <i class="bi {{ $module->icon ?? 'bi-circle' }} px-3"></i>
                            <span>{{ $module->name }}</span>
                        </a>
                    @endif
                </li>
            @endforeach



            <!-- End Components Nav -->
        </ul>

  </aside>

<main class="py-3">
    @yield('content')
</main>

<footer id="footer" class="footer">
    <div class="copyright">

    </div>
    <div class="credits">

    </div>
  </footer><!-- End Footer -->

<script>
    $(document).ready(function() {
        $('#users_table').DataTable();
    });
    $(document).ready(function() {
        $('#modules_table').DataTable();
    });

</script>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
<script src="{{ asset('v3/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('v3/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('v3/assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('v3/assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('v3/assets/vendor/quill/quill.min.js') }}"></script>
<script src="{{ asset('v3/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('v3/assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('v3/assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ asset('v3/assets/js/main.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<!-- cdn for js tables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <!-- Latest jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


</body>


</html>
