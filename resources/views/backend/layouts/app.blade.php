<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Dashboard</title>
    <!-- Custom fonts for this template-->
    <link href="{{asset('public/assets/backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="{{asset('public/assets/backend/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" integrity="sha512-mSYUmp1HYZDFaVKK//63EcZq4iFWFjxSL+Z3T/aCt4IO9Cejm03q3NKKYN6pFQzY0SBOr8h+eCIAZHPXcpZaNw==" crossorigin="anonymous" referrerpolicy="no-referrer" />    <link href="{{asset('public/assets/backend/css/style.css')}}" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="{{asset('public/assets/backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ asset('public/assets/backend/css/jquery-ui.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('public/assets/backend/vendor/datatables/Buttons-2.0.1/css/buttons.bootstrap.css') }}" rel="stylesheet"/>
    <link href="{{asset('public/assets/backend/favicon.ico')}}" rel="icon" type="image/x-icon"/>

    <style>
        td.action {
            display: flex;
            gap: 10px;
        }
    </style>

    @yield('style')
</head>

<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">

    <!-- Sidebar -->
    @include('backend.includes.navigation')
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content" class="">
            <!-- Topbar -->
        @include('backend.includes.header')
        <!-- End of Topbar -->
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Content -->
                @yield('content')
                <!-- Page Content -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="#" onclick="event.preventDefault(); document.getElementById('logout-admin').submit();">{{ __('Logout') }}</a>
                <form id="logout-admin" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                    @csrf
                    {{ method_field('POST') }}
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('public/assets/backend/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('public/assets/backend/js/jquery-ui.min.js') }}"></script>
<!-- Core plugin JavaScript-->
<script src="{{asset('public/assets/backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<!-- Custom scripts for all pages-->
<script src="{{asset('public/assets/backend/js/sb-admin-2.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- Page level plugins -->
<script src="{{asset('public/assets/backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('public/assets/backend/js/demo/datatables-demo.js')}}"></script>

<script src="{{asset('public/assets/backend/vendor/datatables/Buttons-2.0.1/js/dataTables.buttons.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/backend/vendor/datatables/Buttons-2.0.1/js/buttons.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/backend/vendor/datatables/Buttons-2.0.1/js/buttons.html5.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/backend/vendor/datatables/Buttons-2.0.1/js/buttons.print.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/backend/vendor/datatables/pdfmake-0.1.36/pdfmake.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/backend/vendor/datatables/pdfmake-0.1.36/vfs_fonts.js')}}" type="text/javascript"></script>
<script src="{{asset('public/assets/backend/vendor/datatables/JSZip-2.5.0/jszip.js')}}" type="text/javascript"></script>

@stack('js')
@yield('script')
</body>

</html>
