<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('resources/vendor/jquery-3.3.1.min.js') }}"></script>
    
    @yield('scripts')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div>
        Lang: {{ app()->getLocale() }}<br/>
        <a href="{{ url()->to('lang?code=es') }}">Spanish</a><br/>
        <a href="{{ url()->to('lang?code=en') }}">English</a>
    </div>
    <div id="app">

        <main class="py-4">
            @yield('content')
        </main>
        
    </div>
</body>
</html>
