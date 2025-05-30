<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Privykart</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- datatable -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">

    <!-- end datatable -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('/vendors/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendors/chartist/chartist.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />

    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="http://t4t5.github.io/sweetalert/dist/sweetalert.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('/images/favicon.png') }}" />




    <style>
        .error {
            color: #FF0000;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        @include('subadmin.layouts.header')

        <div class="container-fluid page-body-wrapper">
            @include('subadmin.layouts.sidebar')
            @include('sweetalert::alert')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        @yield('contant')
                    </div>
                </div>

                @include('subadmin.layouts.footer')



                <!-- plugins:js -->
                <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                <!-- endinject -->







                <!-- data table -->
                <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
                <!-- end data table -->
                <!-- Plugin js for this page -->
                <script src="{{ asset('/vendors/chart.js/Chart.min.js') }}"></script>
                <script src="{{ asset('/vendors/moment/moment.min.js') }}"></script>
                <script src="{{ asset('/vendors/daterangepicker/daterangepicker.js') }}"></script>
                <script src="{{ asset('/vendors/chartist/chartist.min.js') }}"></script>


                {{-- validation --}}
                <script type="text/javascript"
                    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
                {{-- end validation --}}



                {{-- datepicker --}}
                <!-- Load jQuery UI CSS  -->
                
                <!-- Load jQuery JS -->
                <!-- Load jQuery UI Main JS  -->
                <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>

                {{-- end datepicker --}}





                <!-- End plugin js for this page -->
                <!-- inject:js -->
                <script src="{{ asset('js/off-canvas.js') }}"></script>
                <script src="{{ asset('js/misc.js') }}"></script>
                <!-- endinject -->
                <!-- Custom js for this page -->
                <script src="{{ asset('/js/dashboard.js') }}"></script>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('.table').DataTable();
                        
                    });


                    // onload-header
                    $(window).on('load', function() {
                        // var id = $("#onload-header").data('id');
                        $.ajax({
                            type: 'get',
                            url: '{{ route('user.detail') }}',
                            // data:'_token = <?php //echo csrf_token()
                            ?>',
                            success: function(data) {
                                data = JSON.parse(data);
                                var homeUrl = '{{ url('/') }}';
                                var profileUrl = homeUrl + '/profile/' + data['profile'];
                                $(".profile-image").attr('src', profileUrl);
                                $("#userName").text(data['name']).toUpperCase();
                                $("#userEmail").text(data['email']);
                                var profileUri = '{{ route('admin.profile') }}/' + data['id'];
                                $("#uri").attr('href', profileUri);
                            }
                        });
                    });

                    $(document).ready(function() {
                        $('.numeric').on('input', function() {
                            $(this).val($(this).val().replace(/[^0-9]/g, ''));
                        });
                    });
                </script>

                <!-- End custom js for this page -->
