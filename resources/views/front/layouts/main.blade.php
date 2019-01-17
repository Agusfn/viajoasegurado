<!DOCTYPE HTML>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>@yield('title') - {{ config('app.name') }}</title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="og:url" property="og:url" content="{{ Request::url() }}">
    <meta name="og:title" property="og:title" content="@yield('title') - {{ config('app.name') }}">
    <meta name="og:image" property="og:image" content="{{ asset('front/img/logo.png') }}">
    <meta name="og:type" property="og:type" content="website">     
    @yield('meta-tags')
    
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" href="{{ asset('front/css/vendor/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/vendor/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/vendor/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/vendor/icheck/square/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/mystyles.css') }}">
    @yield('custom-css')
    
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon.png') }}">

    <script src="{{ asset('front/js/vendor/modernizr.js') }}"></script>

</head>

<body>


    <div class="global-wrap">
        
        
        @include('front.layouts.header')

        
        @yield('content')


        @include('front.layouts.footer')


        <script src="{{ asset('front/js/vendor/jquery.js') }}"></script>
        <script src="{{ asset('front/js/vendor/bootstrap.js') }}"></script>
        <script src="{{ asset('front/js/vendor/slimmenu.js') }}"></script>
        <script src="{{ asset('front/js/vendor/moment.js') }}"></script>        
        <script src="{{ asset('front/js/vendor/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('front/js/vendor/bootstrap-timepicker.js') }}"></script>
        <script src="{{ asset('front/js/vendor/dropit.js') }}"></script>
        <script src="{{ asset('front/js/vendor/icheck.js') }}"></script>
        <script src="{{ asset('front/js/vendor/typeahead-bootstrap3.js') }}"></script>
        <script src="{{ asset('front/js/vendor/magnific.js') }}"></script>
        <script src="{{ asset('front/js/custom.js') }}"></script>
        @yield('custom-js')

    </div>
</body>

</html>


