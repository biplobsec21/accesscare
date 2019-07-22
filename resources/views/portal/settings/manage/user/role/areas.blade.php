@extends('layouts.portal')

@section('title')
	Manage Accessible Areas
@endsection

@section('styles')
	<style>
		.custom-container {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			margin: 2% 2% 0 2%;
		}

		.custom-container > * {
			flex: 0 32%;
			margin-bottom: 2%;
		}

		.role-area .btn:focus {
			box-shadow: unset !important;
		}

		.role-area .btn:hover {
			background-color: inherit;
			color: #034F83;
		}
	</style>
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.settings.manage.user.role') }}">Role Manager</a>
				</li>
				<li class="breadcrumb-item active" aria-current="page">
					@yield('title')
				</li>
			</ol>
		</nav>
		<h2 class="m-0">
			@yield('title')
		</h2>
	</div><!-- end .titleBar -->
	@if(Session::has('alerts'))
		{!! view('layouts.alert-dismiss', ['type' => Session::get('alerts')['type'], 'message' => Session::get('alerts')['msg']]) !!}
	@endif
	<div class="viewData">
		<div class="card mb-1 mb-md-4" style="max-width: 991px">
			<div class="card-header">{{ucwords($role->type->name) . ': ' . ucwords($role->name)}}</div>
			<form method="get" action="{{ route('eac.portal.settings.manage.role.permission.sections') }}">
				@csrf
				<div class="custom-container">
					@foreach ($areas as $area)
						<div class="d-inline-block role-area">
							<button type="button" onClick="toggleCheck(event)"
									class="btn btn-outline-primary btn-block w-100 {{$role->hasArea($area) ? 'active' : ''}}">
								{{ucfirst($area)}}
							</button>
							<input type="hidden" name="areas[{{$area}}]" value="{{$role->hasArea($area) ? '1' : '0'}}"/>
						</div>
					@endforeach
				</div>
				<input type="hidden" name="role_id" value="{{$role->id}}"/>
				<button type="submit" class="btn btn-success w-100">Next</button>
			</form>
		</div><!-- /.card -->
	</div><!-- end .viewData -->
@endsection
@section('scripts')
	<script>
		function toggleCheck(event) {
			let $target = $(event.currentTarget);
			switch ($target.siblings('input').val()) {
				case("0"):
					$target.siblings('input').val("1");
					$target.addClass('active');
					break;
				case("1"):
					$target.siblings('input').val("0");
					$target.removeClass('active');
					break;
			}
		}
	</script>
@endsection
