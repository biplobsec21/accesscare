@extends("layouts.app")
@section('content')
	<h2 class="bg-danger text-white text-center display-2">Dev Site</h2>
	<div class="card">
		<div id="header" class="text-center mb-3">
			<img src="https://www.earlyaccesscare.com/images/eac_mini.png" class="img-fluid"/>
		</div>
		<div class="card-body">
			<h2 class="text-primary text-center">Welcome!</h2>
			<div class="row justify-content-center justify-space-between">
				<div class="col-auto">
					<a dusk="eac-index-link-login" href="{{ route('eac.auth.getSignIn') }}" class="btn btn-success">
						Portal Login
					</a>
				</div>
				<div class="col-auto">
					<a href="{{ route('eac.auth.getSignUp') }}" class="btn btn-secondary">
						Register
					</a>
				</div>
			</div>
		</div>
		<div class="card-footer text-center">
			<div class="row justify-content-between">
				<div class="col-auto">
					<a href="" class="btn btn-light btn-sm">
						Website v2
					</a>
				</div>
				<div class="col-auto">
					<a href="https://dev.earlyaccesscare.com/" class="btn btn-light btn-sm">
						Development Area
					</a>
				</div>
			</div>
		</div>
	</div>
@endsection
