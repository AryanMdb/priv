<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <title>@yield('title')</title>
        <meta content="" name="description">
        <meta content="" name="keywords">
        <!-- Favicons -->
        <link href="{{asset('images/favicon.png')}}" rel="icon">
        <link href="{{asset('/cms_assets/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('/cms_assets/css/fontawesome.css')}}" rel="stylesheet">
        <link href="{{asset('/cms_assets/css/style.css')}}" rel="stylesheet">
        <link href="{{asset('/cms_assets/css/responsive.css')}}" rel="stylesheet">
    </head>
    <body>
        @yield('contant')
    </body>
    <script type="text/javascript" src="{{asset('/cms_assets/js/jquery-3.6.0.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/cms_assets/js/bootstrap.min.js')}}"></script>

</html>