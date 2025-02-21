<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Privykart</title>

    <!-- Plugins: CSS -->
    <link rel="stylesheet" href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <!-- End inject -->

    <!-- Datatable -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <!-- End Datatable -->

    <!-- Plugin CSS for this page -->
    <link rel="stylesheet" href="{{ asset('/vendors/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('/vendors/chartist/chartist.min.css') }}">
    <!-- End plugin CSS for this page -->

    <!-- Layout Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />


    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="http://t4t5.github.io/sweetalert/dist/sweetalert.css">

    <link rel="stylesheet" href="https://s.cdpn.io/55638/selectize.0.6.9.css">
    <script src="https://s.cdpn.io/55638/selectize.min.0.6.9.js"></script>
    <!-- End Layout Styles -->

    <link rel="shortcut icon" href="{{ asset('/images/favicon.png') }}" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-notifications.min.css">

    <style>
        .error {
            color: #FF0000;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        @include('admin.layouts.header')

        <div class="container-fluid page-body-wrapper">
            @include('admin.layouts.sidebar')
            @include('sweetalert::alert')

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        @yield('contant')
                    </div>
                </div>

                @include('admin.layouts.footer')

                <!-- Plugins: JS -->
                <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
                <link rel="stylesheet"
                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                <!-- End inject -->

                <!-- Data Table -->
                <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
                <!-- End Data Table -->

                <!-- Plugin JS for this page -->
                <script src="{{ asset('/vendors/chart.js/Chart.min.js') }}"></script>
                <script src="{{ asset('/vendors/moment/moment.min.js') }}"></script>
                <script src="{{ asset('/vendors/daterangepicker/daterangepicker.js') }}"></script>
                <script src="{{ asset('/vendors/chartist/chartist.min.js') }}"></script>
                <!-- End Plugin JS for this page -->

                <!-- Validation -->
                <script type="text/javascript"
                    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
                <!-- End Validation -->

                <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
                <script src="https://js.pusher.com/beams/1.0/beams.min.js"></script>
                <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>

                <!-- Datepicker -->
                <!-- Load jQuery UI CSS -->
                <!-- Load jQuery JS -->
                <!-- Load jQuery UI Main JS -->
                <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
                <!-- End Datepicker -->

                <!-- End Plugin JS for this page -->
                <!-- Inject: JS -->
                <script src="{{ asset('js/off-canvas.js') }}"></script>
                <script src="{{ asset('js/misc.js') }}"></script>
                <!-- End inject -->

                <!-- Custom JS for this page -->
                <script src="{{ asset('/js/dashboard.js') }}"></script>
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('.table').DataTable();
                    });

                    // Onload-header
                    $(window).on('load', function () {
                        $.ajax({
                            type: 'get',
                            url: '{{ route('user.detail') }}',
                            success: function (data) {
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

                    $(document).ready(function () {
                        $('.numeric').on('input', function () {
                            $(this).val($(this).val().replace(/[^0-9]/g, ''));
                        });
                    });

                    window.addEventListener("pageshow", function (event) {
                        var historyTraversal = event.persisted || (typeof window.performance != "undefined" && window.performance.navigation.type === 2);
                        if (historyTraversal) {
                            window.location.reload();
                        }
                    });

                    var pusher = new Pusher('3d50ce863db5c857e0e8', { // Ensure this matches your .env
                        cluster: 'mt1',
                        encrypted: true
                    });

                    var channel = pusher.subscribe('my-channel');

                    channel.bind('my-event', function (data) {
                        console.log("Event Data Received:", data);  // Check if the event data is being received
                        if (Notification.permission === "granted") {
                            navigator.serviceWorker.ready.then(function (registration) {
                                registration.showNotification('New Notification', {
                                    body: data.message, // Use the message here
                                    icon: '/images/favicon.png',
                                    data: data.username, // Use username or any other data you want
                                    sound: 'https://www.w3schools.com/html/horse.mp3'
                                });
                            }).catch(function (error) {
                                console.error('Error showing notification:', error);
                            });
                        } else {
                            console.log("Notification permission not granted.");
                        }
                    });

                </script>
            </div>
        </div>
    </div>
</body>

</html>