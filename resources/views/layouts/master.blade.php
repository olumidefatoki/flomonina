<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon --> 
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('assets/images/flomuvina_logo.jpeg') }}">
    <title>@yield('title')</title>
    @yield('link')
    
    <link href="URL::to('assets/node_modules/Magnific-Popup-master/dist/magnific-popup.css') }}" rel="stylesheet">

    <!-- Data Table CSS -->
    <link href="{{ URL::to('assets/datatable/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('assets/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('assets/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::to('assets/toastr/toastr.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ URL::to('dist/css/style.min.css') }}" rel="stylesheet">
    

</head>

<body class="skin-blue fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Flomuvina</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        @include('partials.topbar')
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        @include('partials.sidebar')
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            @yield('content')
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer">
        &copy;	2021
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ URL::to('assets/node_modules/jquery/jquery-3.2.1.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ URL::to('assets/node_modules/popper/popper.min.js') }}"></script>
    <script src="{{ URL::to('assets/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ URL::to('dist/js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--Wave Effects -->
    <!-- <script src="dist/js/waves.js"></script> -->
    <!--Menu sidebar -->
    <script src="{{ URL::to('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ URL::to('dist/js/custom.min.js') }}"></script>
    <script src="{{ URL::to('assets/node_modules/moment/moment.js') }}"></script>

    <!-- Footable -->
    <script src="{{ URL::to('assets/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::to('assets/datatable/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::to('assets/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::to('assets/toastr/toastr.min.js') }}"></script>
    <!--FooTable init-->
  @yield('script')

</body>

</html>
