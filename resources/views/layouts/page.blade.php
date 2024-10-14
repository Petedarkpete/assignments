<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>{{ config('app.name', 'Reports') }}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
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

          <!-- For Charts -->
          <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>
<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center p-5 bg-info">

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
  <aside id="sidebar" class="sidebar mt-4 bg-info">
        
        <ul class="sidebar-nav" id="sidebar-nav" style="">
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route ('dashboard')}}">
                <i class="bi bi-bar-chart-fill px-3"></i>
                <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('upload_ass')}}">
                <i class="bi bi-cloud-arrow-up px-3"></i><span>Upload Assignment</span></i>
                </a>
                
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="">
                <i class="bi bi-journal px-3"></i><span>Uploads</span></i>
                </a>
                
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('submit_ass')}}">
                <i class="bi bi-send px-3"></i><span>Submit</span></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('year')}}">
                <i class="bi bi-calendar px-3"></i><span>Grade</span></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('course')}}">
                <i class="bi bi-book px-3"></i><span>Course</span></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route('class')}}">
                <i class="bi bi-person-lines-fill px-3"></i><span>Class</span></i>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{route ('users')}}">
                <i class="bi bi-person-circle px-3"></i><span>Users</span></i>
                </a>
                
            </li>
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
