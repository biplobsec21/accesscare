@extends('layouts.portal')

@section('title')
	Add Depot
@endsection

@section('content')
	<div class="titleBar">
		<div class="row justify-content-between">
			<div class="col-md col-lg-auto">
				<h2 class="m-0">
					@yield('title')
				</h2>
			</div>
			<div class="col-md col-lg-auto ml-lg-auto">
				<ol class="breadcrumb">
					<li class="breadcrumb-item active" aria-current="page">
						@yield('title')
					</li>
				</ol>
			</div>
		</div>
	</div><!-- end .titleBar -->
	<form method="post" action="{{ route('eac.portal.depot.store') }}">
		{{ csrf_field() }}
		<div class="viewData">
			<div class="row m-b-10">
				<div class="col-xl-12">
					<div class="card m-b-30">
						<div class="card-header bg-secondary p-10">
							<a class="btn btn-light" href="{{ url()->previous() }}">
								<- Back
							</a>
							<button class="btn btn-success">
								Save
							</button>
							<input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
						</div>
						<div class="card-body p-10">
							<input type="text" name="depot_name" placeholder="Depot Name" class="form-control">
							<br/>
							<input type="text" name="depot_addr1" placeholder="Address Line 1" class="form-control">
							<input type="text" name="depot_addr2" placeholder="Address Line 2" class="form-control">
							<input type="text" name="depot_city" placeholder="City" class="form-control">
							<input type="text" name="depot_zip" placeholder="ZIP Code" class="form-control ">
							<select name="depot_state_province" class="form-control custom-select">
								<option value="" selected hidden>--State--</option>
								@foreach($states as $state)
									<option value="{{ $state->id }}">{{ $state->name }}</option>
								@endforeach
							</select>
							<select name="depot_country_id" class="form-control custom-select">
								<option value="" selected hidden>--Country--</option>
								@foreach($countries as $country)
									<option value="{{ $country->id }}">{{ $country->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection

@section('scripts')
@endsection



