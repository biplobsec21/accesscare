@extends('layouts.portal')
<style>
	.label_required:after {
		content: "*";
		color: red;
	}
</style>
@section('title')
	Create Lot
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
				</li>
				<li class="breadcrumb-item">
					<a href="{{route('eac.portal.lot.list.all')}}">All Lots</a>
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

	<form method="post" action="{{ route('eac.portal.lot.store') }}">
		{{ csrf_field() }}
		<input type="hidden" name="redirect" value="eac.portal.lot.list.all">
		<div class="actionBar">
			<a href="{{ route('eac.portal.lot.list.all') }}" class="btn btn-light">
				<i class="far fa-angle-double-left"></i> Go back
			</a>
		</div><!-- end .actionBar -->

		@include('include.alerts')
		<div class="viewData">
			<div class="row">
				<div class="col-lg-4 col-xl order-lg-2">
					<div class="instructions mb-3">
						Instructions
					</div>
				</div>
				<div class="col-lg-8 col-xl-7 order-lg-1">
					<div class="card card-body">
						<h5 class="text-gold mb-2 mb-xl-4">
							Lot Information
						</h5>
						<div class="row">
							<div class="col-md mb-3">
								<label class="d-block label_required">Drug</label>
								<select name="drug_id" id="drug_id"
								        class="form-control {{ $errors->has('drug_id') ? ' is-invalid' : '' }}"
								        required="required">
									<option disabled hidden selected value="">-- Select --</option>
									@foreach($drugs as $drug)
										<option value="{{ $drug->id }}">
											{{ $drug->name }}
										</option>
									@endforeach
								</select>
								<div class="invalid-feedback">
									{{ $errors->first('drug_id') }}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md mb-3" id="dosage_id">
								<label class="d-block label_required">Component and Dosage</label>
								<select name="dosage_id" class="form-control">
									<option disabled="true" selected="selected">Select Drug First</option>
								</select>
								<div class="invalid-feedback">
									{{ $errors->first('dosage_id') }}
								</div>
							</div>
							<div class="col-md mb-3">
								<label class="d-block label_required">Depot</label>
								@if($depot)
									<select class="form-control" disabled>
										<option value="{{$depot->id}}">
											{{$depot->name}}
										</option>
									</select>
									<input type="hidden" name="depot_id" value="{{$depot->id}}"/>
									<input type="hidden" name="redirect" value="1"/>
								@else
									<select name="depot_id"
									        class="form-control {{ $errors->has('depot_id') ? ' is-invalid' : '' }}"
									        required="required">
										<option disabled hidden selected value="">-- Select --</option>
										@foreach($depots as $depot)
											<option value="{{ $depot->id }}">{{ $depot->name }}</option>
										@endforeach
									</select>
									<div class="invalid-feedback">
										{{ $errors->first('depot_id') }}
									</div>
								@endif
							</div>
						</div>
						<div class="row mb-3">
							<div class="col-md col-lg-5 col-xl-4 mb-3">
								<label class="d-block label_required">Lot Number</label>
								<input type="text" name="number" placeholder="Lot Number" value="{{ old('number') }}"
								       class="form-control {{ $errors->has('number') ? ' is-invalid' : '' }}"
								       required="required">
								<div class="invalid-feedback">
									{{ $errors->first('number') }}
								</div>
							</div>
							<div class="col-md mb-3">
								<label class="d-block label_required">Stock</label>
								<input type="number" name="stock" placeholder="Stock"
								       class="form-control {{ $errors->has('stock') ? ' is-invalid' : '' }}"
								       required="required">
								<div class="invalid-feedback">
									{{ $errors->first('stock') }}
								</div>
							</div>
							<div class="col-md mb-3">
								<label class="d-block label_required">Minimum</label>
								<input type="number" name="minimum" placeholder="Minimum"
								       class="form-control {{ $errors->has('minimum') ? ' is-invalid' : '' }}"
								       required="required">
								<div class="invalid-feedback">
									{{ $errors->first('minimum') }}
								</div>
							</div>
						</div><!-- /.row -->
						<div class="row">
							<div class="ml-auto mr-auto col-sm-10 col-md-8 col-lg-6">
								<button class="btn btn-success btn-block" type="submit">
									<i class="far fa-check"></i> Save Lot
								</button>
							</div>
						</div>
					</div>
				</div>
			</div><!-- /.row -->
		</div>
	</form>
@endsection

@section('scripts')
	<script type="text/javascript">
        $(function () {
            $('#drug_id').change(function () {
                var id = $(this).val();
                $('#dosage_id').html('<span>Loading..</span>');
                $.ajax({
                    url: '{{ route('eac.portal.lot.get.dosage')}}',
                    dataType: 'html',
                    method: 'post',
                    data: {drug_id: id},
                    success: function (data) {
                        $('#dosage_id').html(data);
                    }
                });
            });


        });
	</script>
@endsection
