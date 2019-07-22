@extends('layouts.portal')

@section('title')
	Edit Lot
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item">
					<a href="{{route('eac.portal.getDashboard')}}">Dashboard</a>
				</li>
				@if($_GET['depot'])
					<li class="breadcrumb-item">
						<a href="{{route('eac.portal.depot.list.all')}}">All Depots</a>
					</li>
					<li class="breadcrumb-item">
						<a href="{{route('eac.portal.depot.edit', $_GET['depot'])}}">Edit Depot</a>
					</li>
				@else
					<li class="breadcrumb-item">
						<a href="{{route('eac.portal.lot.list.all')}}">All Lots</a>
					</li>
				@endif
				<li class="breadcrumb-item active" aria-current="page">
					@yield('title')
				</li>
			</ol>
		</nav>
		<h6 class="m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			<small>Lot:</small> {{ $lot->number }}
		</h2>
	</div><!-- end .titleBar -->

	<form method="post" action="{{ route('eac.portal.lot.edit', $lot->id) }}">
		{{ csrf_field() }}
		<input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
		<div class="row">
			<div class="col-lg-10 col-xl-8">
				<div class="actionBar">
					@if($_GET['depot'])
						<a href="{{ route('eac.portal.depot.edit', $_GET['depot']) }}" class="btn btn-warning ">
							<i class="far fa-arrow-left"></i> Edit Depot
						</a>
					@else
						<a href="{{ route('eac.portal.lot.list.all') }}" class="btn btn-warning ">
							<i class="far fa-arrow-left"></i> Lot List
						</a>
					@endif
				</div><!-- end .actionBar -->
			</div>
		</div><!-- /.row -->
		<div class="viewData">
			<div class="row">
				<div class="col-lg-10 col-xl-8">
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
									@foreach($drug_all as $drug)
										<option
											value="{{ $drug->id }}" {{ ($drugs->count() > 0) && $drugs[0]->id == $drug->id ? 'selected' : ''}}>
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
							<div class="col-5 col-sm-6 mb-3" id="dosage_id">
								<label class="d-block label_required">Component and Dosage</label>
								<select name="dosage_id" class="form-control">
									<option disabled hidden selected value="">-- Select --</option>
									@if($drugs->count() > 0)
										@foreach($drugs->sortBy('name') as $drug)
											<optgroup label="{{ $drug->name }}">
												@foreach($drug->components as $component)
													@foreach($component->dosages as $dosage)
														<option value="{{ $dosage->id }}"
														        @if($lot->dosage->id == $dosage->id) selected @endif>
															{{ $dosage->form && $dosage->form->name ?  $dosage->form->name : ''}}
															{{ $dosage->amount  }}
															<small>{{ $dosage->unit && $dosage->unit->name ? $dosage->unit->name : '' }}</small>
														</option>
													@endforeach
												@endforeach
											</optgroup>
										@endforeach
									@endif
								</select>
							</div>
							<div class="col-sm-6 mb-3">
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
									<select name="depot_id" class="form-control">
										<option disabled hidden selected value="">-- Select --</option>
										@foreach($depots as $depot)
											<option value="{{ $depot->id }}"
											        @if($lot->depot_id == $depot->id) selected @endif>{{ $depot->name }}</option>
										@endforeach
									</select>
									<div class="invalid-feedback">
										{{ $errors->first('depot_id') }}
									</div>
								@endif
							</div>
							<div class="col-sm-4 mb-3">
								<label class="d-block label_required">Lot Number</label>
								<input type="text" name="number" value="{{ $lot->number }}" class="form-control">
							</div>
							<div class="col-sm-4 mb-3">
								<label class="d-block label_required">Minimum Threshold</label>
								<input type="text" name="minimum" value="{{ $lot->minimum }}" class="form-control">
							</div>
							<div class="col-sm-4 mb-3">
								<label class="d-block label_required">Stock</label>
								<input type="text" name="stock" value="{{ $lot->stock }}" class="form-control">
							</div>

						</div>
						<div class="row">
							<div class="ml-auto mr-auto col-sm-10 col-md-8 col-lg-6">
								<button class="btn btn-success btn-block" type="submit">
									<i class="fas fa-save fa-fw"></i> Save
								</button>
							</div>
						</div><!-- /.row -->
					</div>
				</div><!-- /.row -->
			</div>
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

        function Confirm_Delete(param) {

            swal({
                title: "Are you sure?",
                text: "Want to delete it",
                icon: "warning",
                buttons: [
                    'No, cancel it!',
                    'Yes, I am sure!'
                ],
                dangerMode: true,
            }).then(function (isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Successfull!',
                        text: 'Content deleted!',
                        icon: 'success'
                    }).then(function () {
                        $.post("{{route('eac.portal.lot.delete')}}",
                            {
                                id: param
                            });
                        // return false;
                        swal.close();

                        $(location).attr('href', '{{route('eac.portal.lot.list.all')}}') // <--- submit form programmatically
                    });
                } else {
                    swal("Cancelled", "Operation cancelled", "error");
                }
            })
        }
	</script>
@endsection
