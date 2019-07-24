<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>
		@yield('title') | Early Access Care
	</title>
	<link rel="shortcut icon" href="{{ asset('/images/favicon/favicon.ico') }}"/>
	<link rel="stylesheet" href="{{ asset('css/portal/application.css') }}"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.js"></script>
	<script src="/assets/js/uac.js"></script>
</head>
<body id="login">
<div class="container pt-3 pb-3 pt-md-5 pb-md-5">
	@yield('content')
</div>
</body>
</html>