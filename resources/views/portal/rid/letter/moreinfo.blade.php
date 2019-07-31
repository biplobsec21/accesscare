@extends('layouts.portal')
@section('title')
	More Information
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<div class="row">
				<div class="col-sm-auto">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route('eac.portal.rid.list') }}">All RIDs</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{ route("eac.portal.rid.show", $rid->id) }}">View</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							@yield('title')
						</li>
					</ol>
				</div>
				<div class="col-sm-auto ml-sm-auto d-none d-sm-block">
					<div class="small">
						<strong>Last Updated:</strong>
						@php
							$time = $rid->updated_at;
							
							echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
						@endphp
					</div>
				</div>
			</div>
		</nav>
		<h6 class="title small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{$rid->number}}
		</h2>
		<div class="small d-sm-none">
			<strong>Last Updated:</strong>
			@php
				$time = $rid->updated_at;
				
				echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
			@endphp
		</div>
	</div><!-- end .titleBar -->
	@include('include.alerts')
	<div class="viewData">
		<div class="row">
			<textarea class="form-control{{ $errors->has('html') ? ' is-invalid' : '' }} editor" rows="10" id="html" name="html" data-field="text"></textarea>
		</div>
	</div>
@endsection

@section('scripts')
@endsection
