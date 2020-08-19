<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AD Co') }}   | @yield('title') </title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1,shrink-to-fit=no">
    <link rel="canonical" href="{{ config('app.url', 'ad.net.sa') }}">
    <link rel="icon" href="{{url('assets/images/favicon.png')}}" type="image/png">
    <!-- Stylesheets ============================================= -->
    <link rel="stylesheet" href="{{url('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('assets/css/home.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css" />
    <!--link(rel='stylesheet',href='css/home-ltr.css')-->
    <link href="https://fonts.googleapis.com/css?family=Cairo:400,600,700&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="{{url('assets/css/custom.css')}}" />
    <link rel="stylesheet" href="{{url('assets/css/intlTelInput.min.css')}}" />

    <!-- Scripts ============================================= -->
</head>
<body>


    @yield('content')

</body>
    <script src="{{url('assets/js/jquery.js')}}"></script>
    <script src="{{url('assets/js/popper.min.js')}}"></script>
    <script src="{{url('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{url('assets/js/jquery-steps.js') }}"></script>
    <script src="{{url('assets/js/jquery.validate.js') }}"></script>
    <script src="{{url('assets/js/plugin.js')}}">  </script>
    <script src="{{url('assets/js/staps.js')}}">  </script>
    <script src="{{url('assets/js/intlTelInput-jquery.min.js')}}">  </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ar.min.js"></script>
    @yield('jquery')

</html>
