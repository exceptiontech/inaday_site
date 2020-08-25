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
        <!-- Bootstrap CSS -->
        <!--ltr link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"-->
        <link href="{{url('vendor/bootstrap-rtl/css/bootstrap-rtl.min.css')}}" rel="stylesheet">

        <!-- slick CSS -->
        <link href="{{url('vendor/slick/slick.css')}}" rel="stylesheet" type="text/css">
        <link href="{{url('vendor/slick/slick-theme.css')}}" rel="stylesheet" type="text/css">

        <!-- font-awesome CSS -->
        <link href="{{url('vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">

        <!-- Custom styles -->
        <link href="{{url('css/style.css')}}" rel="stylesheet">
        <script src="{{url('vendor/jquery/jquery.min.js')}}"></script>
    </head>
    <body class="front rtl">
        @include('front.parts.header')
        @include('front.parts.slider')
        @yield('content')
        @include('front.parts.footer')
    </body>


    <script src="{{url('vendor/popper/popper.min.js')}}"></script>
    <script src="{{url('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- Plugins -->
    <script src="{{url('vendor/jquery-easing/jquery.easing.js')}}"></script>
    <script type="text/javascript" src="{{url('vendor/slick/slick.min.js')}}"></script>
    <script src="{{url('js/functions.js')}}"></script>
    @yield('jquery')
</html>
