@extends('layouts.portal')

@section('title')
	Dashboard
@endsection

@section('content')
	<div class="d-flex justify-content-between align-items-center">
		<h3 class="mb-3 mb-xl-4">
			Welcome to your
			<strong>Dashboard,</strong>
			<span class="text-info">{{\Auth::user()->first_name}}</span>
		</h3>
		<span class="badge badge-primary">{{\Auth::user()->type->name}}</span>
	</div>
	@if(\Auth::user()->type->name == 'Physician')
		<div class="row">
			<div class="col-sm-6 col-xl mb-3 mb-xl-5">
				@include('portal.dashboard.rid-card')
			</div>
			<div class="col-sm-6 col-xl mb-3 mb-xl-5">
				@include('portal.dashboard.group-card')
			</div>
			<div class="col-sm-6 col-xl mb-3 mb-xl-5">
				@include('portal.dashboard.notification-card')
			</div>
			<div class="col-sm-6 col-xl mb-3 mb-xl-5">
				@include('portal.dashboard.profile-card')
			</div>
		</div>
		<div class="viewData">
			<div class="card mb-1 mb-md-4">
				@include('portal.dashboard.rid-table')
			</div>
		</div>
	@endif
	@if(\Auth::user()->type->name == 'Pharmaceutical')
		<div class="row">
			<div class="col-sm-4 mb-3 mb-xl-5">
				@include('portal.dashboard.drug-card')
			</div>
			<div class="col-sm-4 mb-3 mb-xl-5">
				@include('portal.dashboard.notification-card')
			</div>
			<div class="col-sm-4 mb-3 mb-xl-5">
				@include('portal.dashboard.profile-card')
			</div>
		</div>
		<div class="viewData">
			<div class="card mb-1 mb-md-4">
				@include('portal.dashboard.drug-table')
			</div>
		</div>
	@endif
	@if(\Auth::user()->type->name == 'Early Access Care')
		<div class="row">
			<div class="col-sm-6 col-xl mb-3 mb-xl-5">
				@include('portal.dashboard.rid-card')
			</div>
			<div class="col-sm-6 col-xl mb-3 mb-xl-5">
				@include('portal.dashboard.drug-card')
			</div>
			<div class="col-sm-6 col-xl mb-3 mb-xl-5">
				@include('portal.dashboard.user-card')
			</div>
			<div class="col-sm-6 col-xl mb-3 mb-xl-5">
				@include('portal.dashboard.notification-card')
			</div>
		</div>
		<div class="viewData">
			<div class="card mb-1 mb-md-4">
				@include('portal.dashboard.shipment-table')
			</div>
		</div>
	@endif
@endsection

@section('scripts')
@endsection
