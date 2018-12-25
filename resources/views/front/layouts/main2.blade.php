<!DOCTYPE HTML>
<html>

<head>
    <title>@yield('title')</title>


    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta name="keywords" content="Template, html, premium, themeforest" />
    <meta name="description" content="Traveler - Premium template for travel companies">
    <meta name="author" content="Tsoy">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- GOOGLE FONTS -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,600' rel='stylesheet' type='text/css'>
    <!-- /GOOGLE FONTS -->
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/icomoon.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/mystyles.css') }}">

    <link rel="stylesheet" href="{{ asset('front/css/icheck/square/blue.css') }}">

    @yield('custom-css')

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
        <script src="{{ asset('front/js/vendor/bootstrap-datepicker.js') }}"></script>
        <script src="{{ asset('front/js/vendor/bootstrap-timepicker.js') }}"></script>
        <script src="{{ asset('front/js/vendor/nicescroll.js') }}"></script>
        <script src="{{ asset('front/js/vendor/dropit.js') }}"></script>
        <script src="{{ asset('front/js/vendor/ionrangeslider.js') }}"></script>
        <script src="{{ asset('front/js/vendor/icheck.js') }}"></script>
        <script src="{{ asset('front/js/vendor/fotorama.js') }}"></script>
        <!--script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script-->
        <!--script src="{{ asset('front/js/typeahead.js') }}"></script-->
        <script src="{{ asset('front/js/vendor/typeahead-bootstrap3.js') }}"></script>
        <script src="{{ asset('front/js/vendor/card-payment.js') }}"></script>
        <script src="{{ asset('front/js/vendor/magnific.js') }}"></script>
        <script src="{{ asset('front/js/vendor/owl-carousel.js') }}"></script>
        <script src="{{ asset('front/js/vendor/fitvids.js') }}"></script>
        <script src="{{ asset('front/js/vendor/tweet.js') }}"></script>
        <script src="{{ asset('front/js/vendor/countdown.js') }}"></script>
        <script src="{{ asset('front/js/vendor/gridrotator.js') }}"></script>
        <script src="{{ asset('front/js/vendor/moment.js') }}"></script>
        <script src="{{ asset('front/js/custom.js') }}"></script>

        @yield('custom-js')

        <script>
        $(document).ready(function(){
                $('input.icheckbox').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'icheckbox_square-blue'
                });
        });
        </script>

    </div>
</body>

</html>


