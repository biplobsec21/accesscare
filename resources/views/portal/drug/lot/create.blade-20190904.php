@extends('layouts.portal')

@section('title')
	Add Lot
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
	<form method="post" action="{{ route('eac.portal.lot.store') }}">
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
						</div>
						<div class="card-body p-10">
							<input type="text" name="number" placeholder="Lot Number" class="form-control">
							<select name="dosage_id" class="form-control custom-select">
								<option value="" hidden>--Dosage--</option>
								@foreach($drugs->sortBy('name') as $drug)
									<optgroup label="{{ $drug->name }}">
										@foreach($drug->components as $component)
											@foreach($component->dosages as $dosage)
												<option value="{{ $dosage->id }}">
													{{ $dosage->form->name }} {{ $dosage->amount }}
													<small>{{ $dosage->unit->name }}</small>
												</option>
											@endforeach
										@endforeach
									</optgroup>
								@endforeach
							</select>
							<select name="depot_id" class="form-control custom-select">
								<option value="" hidden>--Depot--</option>
								@foreach($depots as $depot)
									<option value="{{ $depot->id }}">{{ $depot->name }}</option>
								@endforeach
							</select>
							<input type="text" name="stock" placeholder="Stock" class="form-control">
							<input type="text" name="minimum" placeholder="Minimum" class="form-control">
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
@endsection

@section('scripts')
@endsection
