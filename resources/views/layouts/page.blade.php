<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ config('app.name', 'Reports') }}</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('v3/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('v3/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('v3/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('v3/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('v3/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('v3/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('v3/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <script src="{{ asset('v3/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>


  <!-- Template Main CSS File -->
  <link href="{{ asset('v3/assets/css/style.css') }}" rel="stylesheet">

  <!-- DataTables CDN -->
  <link rel="stylesheet" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">

  <!-- SweetAlert -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.6/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- Additional Styles -->
  @stack('styles')
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center bg-info shadow-sm">
    <div class="d-flex align-items-center justify-content-between">
        <div class="ms-3 py-2">
            <img src="/images/logo.png" alt="Logo" class="img-fluid" style="height: 100px; max-height: 90px;">
        </div>
    </div>

    <i class="bi bi-list toggle-sidebar-btn ms-5 me-3"></i>

    <nav class="header-nav ms-auto me-3">
  <div class="dropdown">
    <button class="btn btn-light btn-sm dropdown-toggle" type="button"
            id="dropdownMenuButton"
            data-bs-toggle="dropdown"
            aria-expanded="false">
      {{ Session::get('name') }}
    </button>

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
      <li>
        <a class="dropdown-item text-danger" href="#"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
      </li>
    </ul>
  </div>
</nav>

  </header>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar bg-info">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link collapsed {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-bar-chart-fill px-3"></i>
          <span>Dashboard</span>
        </a>
      </li>

      @foreach($modules as $module)
        <li class="nav-item">
          @if ($module->submodules->isNotEmpty())
            <a class="nav-link collapsed" data-bs-toggle="collapse" href="#module-{{ $module->id }}" aria-expanded="false">
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
    </ul>
  </aside>

  <!-- ======= Main Content ======= -->
  <main class="py-4 px-3">
    <div class="container-fluid">
      <!-- Flash Messages -->
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif
      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @yield('content')
    </div>
  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer text-center mt-auto py-3 bg-light border-top">
    <div class="text-muted">
      &copy; {{ now()->year }} {{ config('app.name') }}. All rights reserved.
    </div>
  </footer>

  <!-- JS Libraries -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="{{ asset('v3/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.6/dist/sweetalert2.all.min.js"></script>
  <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

  @stack('scripts')
</body>
</html>

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
