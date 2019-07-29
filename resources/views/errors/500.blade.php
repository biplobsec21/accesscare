<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta name="csrf-token" content="qpzbfKGW7dQpcsQPgpGoFzN9YvF9S46FPIAW4kFc">
	<title>500</title>
	<meta name="keywords" content=""/>
	<meta name="description" content=""/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta property="og:url" content=""/>
	<meta property="og:type" content="website"/>
	<meta property="og:title" content=""/>
	<meta property="og:description" content=""/>
	<meta property="og:image" content="/images/"/>
	<!-- begin shortcut icons -->
	<link rel="shortcut icon" href=""/>
	<!-- /end shortcut icons -->
	<!-- begin cdn stylesheets -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"/>
	<!-- /end cdn stylesheets -->
	<!-- begin in-house stylesheets -->
	<link rel="stylesheet" href="{{ asset('css/public.css') }}">
	<!-- /end in-house stylesheets -->
</head>
<body id="error-pg">
<div class="container d-flex justify-content-center">
	<div class="align-self-center w-100 this">
		<div class="d-flex justify-content-center align-items-center">
			<h3 class="d-inline mr-4 text-warning">500</h3>
			<h4 class="d-inline text-warning">Error</h4>
		</div>
		<h6 class="mb-4 text-center text-muted">{{config('codes')[$exception->getStatusCode()]}}</h6>
		<p class="mb-0 text-center">
			{!! $exception->getMessage() !!}
		</p>
		<p class="mt-5 text-center">
			<a href="/portal/dashboard" class="btn btn-primary btn-lg">
				Return to
				<img src="/images/brand_white_iso.png" style="max-height: 30px;"/>
			</a>
		</p>
	</div>
</div>
</body>
</html>