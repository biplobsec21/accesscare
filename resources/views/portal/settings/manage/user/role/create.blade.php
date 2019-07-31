@extends('layouts.portal')

@section('title')
	Create Role
@endsection

@section('styles')
	<style>
		.custom-container {
			display: flex;
			flex-wrap: wrap;
			justify-content: space-between;
			margin: 0 2%;
		}
		.custom-container > * {
			flex: 0 49%;
			margin-bottom: 2%;
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
	@include('include.alerts')
	<div class="viewData">
		<div class="card mb-1 mb-md-4" style="max-width: 991px">
			<div class="card-header">Add User Role</div>
			<form method="post" action="{{ route('eac.portal.settings.manage.user.role.store') }}">
				@csrf
				<div class="custom-container">
					<div class="mt-2">
						<label for="role_name">Role Name</label>
						<input name="role_name" type="text" value="{{old('role_name')}}"
							   class="form-control{{ $errors->has('role_name') ? ' is-invalid' : '' }}"/>
						<div class="invalid-feedback">{{ $errors->first('role_name') }}</div>
					</div>
					<div class="mt-2">
						<label for="role_type">Type</label>
						<select name="role_type" class="form-control{{ $errors->has('role_type') ? ' is-invalid' : '' }}">
							<option hidden value="">--Select--</option>
							@foreach($types as $type)
								@if(old('role_type') == $type->id)
									<option value="{{$type->id}}" selected>{{$type->name}}</option>
								@else
									<option value="{{$type->id}}">{{$type->name}}</option>
								@endif
							@endforeach
						</select>
						<div class="invalid-feedback">{{ $errors->first('role_type') }}</div>
					</div>
				</div>
				<button type="submit" class="btn btn-success w-100">Next</button>
			</form>
		</div><!-- /.card -->
	</div><!-- end .viewData -->
@endsection
@section('scripts')
@endsection
