<!DOCTYPE html>
<html lang="en">

<head>
  @include('layouts.head')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    @if(route('dashboard'))
    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="{!! asset('assets/images/IBS.png') !!}" alt="IBS" height="60" width="60">
    </div>
    @endif

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      @include('layouts.navbar')
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ url('/dashboard') }}" class="brand-link">
        <img src="{!! asset('assets/images/IBS.png') !!}" alt="IBS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">IBS</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="{!! asset('assets/dist/img/user2-160x160.jpg') !!}" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="/sys/user_account/{{ auth()->user()->id }}/edit" class="d-block">{{ auth()->user()->fullname }}</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          @include('layouts.sidebar')
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <div id="menu-content" tbl="" class="content">
        <section class="content">
          <!-- <div class="container-fluid"> -->
          <br>
          <!-- Main content -->
          @yield('content')
          <!-- /.content -->
          <!-- </div> -->
        </section>
      </div>
    </div>
    <!-- @include('layouts.jsscript') -->
    <!-- /.content-wrapper -->
    @include('layouts.footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <!-- <script src="{!! asset('assets/plugins/jquery/jquery.min.js') !!}"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{!! asset('assets/plugins/jquery-ui/jquery-ui.min.js') !!}"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="{!! asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
  <!-- ChartJS -->
  <script src="{!! asset('assets/plugins/chart.js/Chart.min.js') !!}"></script>
  <!-- Sparkline -->
  <script src="{!! asset('assets/plugins/sparklines/sparkline.js') !!}"></script>
  <!-- JQVMap -->
  <script src="{!! asset('assets/plugins/jqvmap/jquery.vmap.min.js') !!}"></script>
  <script src="{!! asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js') !!}"></script>
  <!-- jQuery Knob Chart -->
  <script src="{!! asset('assets/plugins/jquery-knob/jquery.knob.min.js') !!}"></script>
  <!-- daterangepicker -->
  <script src="{!! asset('assets/plugins/moment/moment.min.js') !!}"></script>
  <script src="{!! asset('assets/plugins/daterangepicker/daterangepicker.js') !!}"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{!! asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
  <!-- Summernote -->
  <script src="{!! asset('assets/plugins/summernote/summernote-bs4.min.js') !!}"></script>
  <!-- overlayScrollbars -->
  <script src="{!! asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') !!}"></script>
  <!-- AdminLTE App -->
  <script src="{!! asset('assets/dist/js/adminlte.js') !!}"></script>

  <!-- DataTable Js -->
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
  <!-- Sweet Alert-->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>

  <!-- Select2 -->
  <script src="{!! asset('assets/plugins/select2/js/select2.full.min.js') !!}"></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script> -->
  <!-- tiny-slider.js -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/min/tiny-slider.js"></script> -->
  
  <!-- <script src="{!! asset('assets/dist/js/owl.carousel.js') !!}"></script> -->
  <!-- owl carousel -->
  <!--   <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.js"></script> -->

  @include('layouts.jsscript')
  <!-- AdminLTE for demo purposes -->
  <!--<script src="{!! asset('assets/dist/js/demo.js') !!}"></script>-->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!--<script src="{!! asset('assets/dist/js/pages/dashboard.js') !!}"></script> -->
</body>

</html>