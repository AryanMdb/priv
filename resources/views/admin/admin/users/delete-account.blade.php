<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v3.8.6">
        <title>Delete account</title>
    
        <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/album/">
    
        <!-- Bootstrap core CSS -->
        <link href="https://getbootstrap.com/docs/4.4/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    
        <!-- Favicons -->
        <link rel="apple-touch-icon" href="https://getbootstrap.com/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
        <link rel="shortcut icon" href="{{ asset('/images/favicon.png') }}" />
        <!-- <link rel="manifest" href="https://getbootstrap.com/docs/4.4/assets/img/favicons/manifest.json"> -->
        <link rel="shortcut icon" href="{{ asset('/images/favicon.png') }}" />
        <!-- <link rel="icon" href="https://getbootstrap.com/docs/4.4/assets/img/favicons/favicon.ico"> -->
        <!-- <meta name="msapplication-config" content="https://getbootstrap.com/docs/4.4/assets/img/favicons/browserconfig.xml"> -->
        <meta name="theme-color" content="#563d7c">
        <!-- Custom styles for this template -->
        <link href="album.css" rel="stylesheet">
        <style>
            section.act_page {
        background: #fafafa;
        padding: 3rem 15px;
        max-width: 800px;
        margin: auto;
    }
    
    .form-control#error-msg-email, .form-control#error-msg-password, {
        border: 1px solid red;
    }
    
    span#error-msg-email, span#error-msg-password {
        color: red;
        font-size: 14px;
        display: none;
    }
    section.act_page h1 {
        font-size: 32px;
        font-weight: 600;
    }
    
    section.act_page form {
        width: 100%;
        background: #fff;
        max-width: 100%;
        padding: 20px 15px;
        box-shadow: 2px 0 10px 0 rgb(5 5 5 / 4%);
        /* border: 1px solid #dddddd8c; */
        border-radius: 5px;
        display: block;
    }
    
    section.act_page form button.btn {
        margin: auto;
        display: block;
    }
    
    p.list-group-item {
        font-size: 14px;
    }
    
    
    section.act_page form input.form-control {
        width: 100%;
    }
    .modal.modal-cmd {
        /* max-width: 530px; */
        right: 0;
        /* margin: auto; */
        /* text-align: center; */
        /* min-height: 300px; */
        padding: 0 15px;
    /*    left: 50%;*/
        right: auto;
    /*    transform: translate(-50%, -100%);*/
        min-height: 100%;
        width: 100%;
    }
    .modal-header button.close:focus {
        outline: navajowhite;
    }
    .modal-header button.close {
        outline: none;
        opacity: 1;
        padding: 4px 10px;
        position: absolute;
        right: 0;
        top: 0;
        background: #ff7070;
        border-radius: 100%;
        color: #fff;
    }
    
    /*custom modal background css */
    .modal.modal-cmd {
        background: #00000085;
    }
    /*.modal.modal-cmd{
        display: block !important;
        -webkit-transform: none;
        transform: none;
    }*/
        </style>
    </head>
<body>
    @include('sweetalert::alert')
    <main role="main">
        <section class="act_page">
            <div class="container text-center">
                <h1>Delete my account</h1>
                <p class="lead text-muted">If you want to permanently delete your account and all of its data...</p>
                <p class="lead text-danger">This action can not be undone.</p>
                <p class="lead text-muted">This will permanently delete your account, files, and personal data...</p>
            </div>
            <br>
            <div class="container">
                <div class="row justify-content-md-center">
                    <div class="col-md-12">
                        <form id="sendOtpForm" method="POST" action="{{ route('send.otp') }}">
                            @csrf
                            <div class="form-group">
                                <label for="phone" class="sr-only">Phone Number</label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number">
                                <span id="error-msg-phone"></span>
                            </div>
                            <button type="button" id="sendOtpBtn" class="btn btn-danger mb-2">Send OTP</button>
                        </form>
                    </div>
                </div>
            </div>
            <div id="otp-section" class="container" style="display:none;">
                <div class="row justify-content-md-center">
                    <div class="col-md-12">
                        <form id="verifyOtpForm" method="POST" action="{{ route('verify.otp') }}">
                            @csrf
                            <div class="form-group">
                                <label for="otp" class="sr-only">OTP</label>
                                <input type="text" class="form-control" name="otp" id="otp" placeholder="Enter OTP">
                                <span id="error-msg-otp"></span>
                            </div>
                            <button type="button" id="deleteAccountBtn" class="btn btn-danger mb-2">Delete Account</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- Modals omitted for brevity -->
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.4/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-6khuMg9gaYr5AxOqhkVIODVIvm9ynTT5J4V1cfthmT+emCG6yVmEZsRHdxlotUnm"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function() {
            $('#sendOtpBtn').click(function(event) {
                var form = $('#sendOtpForm');
                var phone = $('#phone').val();
                event.preventDefault();

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'OTP sent!',
                                text: 'OTP has been sent to your phone number.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            $('#phone').prop('disabled', true);
                            $('#sendOtpBtn').hide();
                            $('#otp-section').show();
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to send OTP. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('#deleteAccountBtn').click(function(event) {
                var form = $('#verifyOtpForm');
                var otp = $('#otp').val();
                var phone = $('#phone').val();

                event.preventDefault();

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        phone: phone,
                        otp: otp
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Account Deleted!',
                                text: 'Your account has been deleted successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.href = "{{ route('account-delete') }}";
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Failed to delete account. Please try again.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
