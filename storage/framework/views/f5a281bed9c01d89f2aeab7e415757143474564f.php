<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Privykart</title>

    <!-- Plugins: CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('vendors/simple-line-icons/css/simple-line-icons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendors/flag-icon-css/css/flag-icon.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('vendors/css/vendor.bundle.base.css')); ?>">
    <!-- End inject -->

    <!-- Datatable -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <!-- End Datatable -->

    <!-- Plugin CSS for this page -->
    <link rel="stylesheet" href="<?php echo e(asset('/vendors/daterangepicker/daterangepicker.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/vendors/chartist/chartist.min.css')); ?>">
    <!-- End plugin CSS for this page -->

    <!-- Layout Styles -->
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/custom.css')); ?>">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />


    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://t4t5.github.io/sweetalert/dist/sweetalert.css">
    <!-- End Layout Styles -->

    <link rel="stylesheet" href="https://s.cdpn.io/55638/selectize.0.6.9.css">
    <script src="https://s.cdpn.io/55638/selectize.min.0.6.9.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <link rel="shortcut icon" href="<?php echo e(asset('/images/favicon.png')); ?>" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap-notifications.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/3.1.3/bootstrap-notify.min.css">


    <!-- End Datepicker -->

    <style>
        .error {
            color: #FF0000;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <?php echo $__env->make('admin.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="container-fluid page-body-wrapper">
            <?php echo $__env->make('admin.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <?php echo $__env->yieldContent('contant'); ?>
                    </div>
                </div>

                <?php echo $__env->make('admin.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                <script src="<?php echo e(asset('vendors/js/vendor.bundle.base.js')); ?>"></script>

                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>

                <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

                <!-- Plugins: JS -->
                <link rel="stylesheet"
                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
                <!-- End inject -->



                <!-- Plugin JS for this page -->
                <script src="<?php echo e(asset('/vendors/chart.js/Chart.min.js')); ?>"></script>
                <script src="<?php echo e(asset('/vendors/moment/moment.min.js')); ?>"></script>
                <script src="<?php echo e(asset('/vendors/daterangepicker/daterangepicker.js')); ?>"></script>
                <script src="<?php echo e(asset('/vendors/chartist/chartist.min.js')); ?>"></script>
                <!-- End Plugin JS for this page -->

                <!-- Validation -->
                <script type="text/javascript"
                    src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
                <!-- End Validation -->

                <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
                

                <!-- Inject: JS -->
                <script src="<?php echo e(asset('js/off-canvas.js')); ?>"></script>
                
                <!-- End inject -->

                <!-- Custom JS for this page -->
                
                <script type="text/javascript">
                    $(document).ready(function () {
                        $('.table').DataTable();
                    });

                    // Onload-header
                    $(window).on('load', function () {
                        $.ajax({
                            type: 'get',
                            url: '<?php echo e(route('user.detail')); ?>',
                            success: function (data) {
                                data = JSON.parse(data);
                                var homeUrl = '<?php echo e(url('/')); ?>';
                                var profileUrl = homeUrl + '/profile/' + data['profile'];
                                $(".profile-image").attr('src', profileUrl);
                                $("#userName").text(data['name']).toUpperCase();
                                $("#userEmail").text(data['email']);
                                var profileUri = '<?php echo e(route('admin.profile')); ?>/' + data['id'];
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

                    // var pusher = new Pusher('3d50ce863db5c857e0e8', {
                    //     cluster: 'mt1',
                    //     encrypted: true
                    // });

                    // var channel = pusher.subscribe('my-channel');

                    // channel.bind('my-event', function (data) {
                    //     console.log("Event Data Received:", data);
                    //     if (Notification.permission === "granted") {
                    //         new Notification("New Order", {
                    //             body: data.message,
                    //             icon: "/images/favicon.png"
                    //         });
                    //     } else {
                    //         console.log("Notification permission not granted.");
                    //     }
                    // });

                    // document.addEventListener('DOMContentLoaded', function () {
                    //     if ('Notification' in window && Notification.permission === 'default') {
                    //         document.body.addEventListener('click', function askNotificationPermission() {
                    //             Notification.requestPermission().then(permission => {
                    //                 if (permission === 'granted') {
                    //                     showNotification();
                    //                 } else {
                    //                     console.log('❌ Notifications denied.');
                    //                 }
                    //             });

                    //             document.body.removeEventListener('click', askNotificationPermission);
                    //         });
                    //     }
                    // });

                    // function showNotification() {
                    //     new Notification('Hello!', {
                    //         body: 'You have enabled notifications.',
                    //         icon: 'https://via.placeholder.com/128'
                    //     });
                    // }

                    if ('serviceWorker' in navigator) {
                        navigator.serviceWorker.register('/service-worker.js')
                            .then(reg => console.log('Service Worker Registered!', reg))
                            .catch(err => console.log('Service Worker Registration Failed!', err));
                    }

                    // Request notification permission
                    document.addEventListener('DOMContentLoaded', function () {
                        if ('Notification' in window && Notification.permission === 'default') {
                            document.body.addEventListener('click', function askNotificationPermission() {
                                Notification.requestPermission().then(permission => {
                                    if (permission === 'granted') {
                                        console.log('✅ Notifications Allowed!');
                                    } else {
                                        console.log('❌ Notifications Denied.');
                                    }
                                });
                                document.body.removeEventListener('click', askNotificationPermission);
                            });
                        }
                    });

                    // Pusher Notification Handling
                    var pusher = new Pusher('3d50ce863db5c857e0e8', {
                        cluster: 'mt1',
                        encrypted: true
                    });

                    var channel = pusher.subscribe('my-channel');

                    channel.bind('my-event', function (data) {
                        console.log("Event Data Received:", data);

                        if ('serviceWorker' in navigator && Notification.permission === "granted") {
                            navigator.serviceWorker.ready.then(function (registration) {
                                registration.showNotification("New Order", {
                                    body: data.message,
                                    icon: "/images/favicon.png"
                                });
                            });
                        } else {
                            console.log("Notification permission not granted or service worker not ready.");
                        }
                    });

                    navigator.serviceWorker.ready.then(function (registration) {
                        registration.showNotification("New Order", {
                            body: data.message,
                            icon: "/images/favicon.png",
                        });
                    });

                </script>
            </div>
        </div>
    </div>
</body>

</html><?php /**PATH /home/1290354.cloudwaysapps.com/bhqcygtvak/public_html/resources/views/admin/layouts/master.blade.php ENDPATH**/ ?>