@php 
    $current_url = \Request::route()->getName();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Privykart Admin</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <!-- <link href="{{ asset('front_assets/images/favicon.png') }}" rel="icon"> -->
    <link href="{{ asset('front_assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front_assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('front_assets/css/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('front_assets/css/lightgallery-bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('front_assets/css/responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('front_assets/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front_assets/css/jquery-ui.css') }}" rel="stylesheet" >
    <link href="{{ asset('front_assets/vendor/datepicker/css/datepicker.css') }}"  rel="stylesheet">
    <link href="{{ asset('front_assets/css/jquery.timepicker.css') }}" rel="stylesheet">
    <link href="{{ asset('front_assets/css/style.css') }}" rel="stylesheet">
    <style>
        .errorTxt{
            color:#dc3545;
        }
    </style>
	@stack('css')
</head>

<body class="@if($current_url == 'home' || $current_url == 'home-index') home @endif">
    <div class="wrapper">
		@include('admin.layouts.header')

		@yield('content')
        
		@include('admin.layouts.footer')
    </div>
    <script type="text/javascript" src="{{ asset('front_assets/js/jquery-3.6.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front_assets/js/popper.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front_assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front_assets/js/slick.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front_assets/js/lightgallery.umd.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front_assets/js/lg-zoom.umd.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front_assets/js/script.js') }}"></script>
    <script type="text/javascript" src="{{ asset('front_assets/vendor/datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script src="{{ asset('admin_assets/js/timepicker.min.js') }}"></script>
    <script src="{{asset('front_assets/js/jquery-ui.js')}}"></script>
    <script src="{{ asset('front_assets/js/toastr.min.js') }}"></script>
    @toastr_render
    
	<script src="https://cdnjs.cloudflare.com/ajax/libs/javascript.util/0.12.12/javascript.util.min.js"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
	<!-- sweetalert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	@stack('js')
</body>

</html>



