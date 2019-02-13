<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<title>@yield('title') - Admin {{ config('app.name') }}</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="robots" content="noindex, nofollow">

	<link rel="stylesheet" href="{{ asset('back/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('back/vendor/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('back/vendor/linearicons/style.css') }}">
	<link rel="stylesheet" href="{{ asset('back/vendor/chartist/css/chartist-custom.css') }}">
	
	<link rel="stylesheet" href="{{ asset('back/css/main.css') }}">
	@yield('custom-css')

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicon.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon.png') }}">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-134361603-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-134361603-1');
	</script>

</head>

<body>

	<div id="wrapper">

		@include('back.layouts.navbar')

		@include('back.layouts.sidebar-nav')

		<div class="main">
			<div class="main-content">
				<div class="container-fluid">
					@yield('content')
				</div>
			</div>
		</div>

	</div>

	<script src="{{ asset('back/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('back/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('back/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('back/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
	<script src="{{ asset('back/vendor/chartist/js/chartist.min.js') }}"></script>
	<script src="{{ asset('back/scripts/klorofil-common.js') }}"></script>
	@yield('custom-js')
</body>

</html>
