@extends('layouts.portal')

@section('title')
	Add Visits
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
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
					Add Visits to {{$rid->number}}
				</li>
			</ol>
		</nav>
		<h6 class="title small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{$rid->number}}
		</h2>
	</div><!-- end .titleBar -->
	
	
	<div class="row">
		<div class="col-lg-8 col-xl-4">
			@include('include.alerts')
			<div class="actionBar">
				<a href="{{ route("eac.portal.rid.show", $rid->id) }}" class="btn btn-secondary">
					<i class="fal fa-angle-double-left"></i>
					View RID
				</a>
			</div><!-- end .actionBar -->
		</div>
	</div><!-- /.row -->
	
	<div class="viewData">
		
		<div class="row">
			<div class="col-lg-8 col-xl-4">
				<form action="{{ route('eac.portal.rid.resupply.store') }}" method="post">
					@csrf
					<input type="hidden" name="rid_id" value="{{ $rid->id }}">
					<div class="mb-3 mb-xl-4">
						@if($drug_supply)
							<div class="card card-body mb-0">
								<div class="row">
									<div class="col-md-6 mb-3">
										<label class="d-block">Delivery Date</label>
										<input name="first_visit_date" type="text" id="first_visit_date" data-minimum="{{$rid->last_visit()->visit_date ?? date('Y-m-d')}}" value="{{ old('first_visit_date') ? old('first_visit_date') : ''}}" class="shipment-datepicker form-control {{ $errors->has('first_visit_date') ? ' is-invalid' : '' }}">
										<div class="invalid-feedback">
											{{ $errors->first('first_visit_date') }}
										</div>
									</div>
									<div class="col-md-6 mb-3">
										<label class="d-block">Days to Deliver</label>
										<input name="days_to_deliver" type="number" value="{{ $country->avg_days_to_deliver_drug ?? null}}" class="form-control {{ $errors->has('days_to_deliver') ? 'is-invalid' : '' }}">
										<div class="invalid-feedback">
											{{ $errors->first('days_to_deliver') }}
										</div>
									</div>
									<div class="col-md-12 mb-3">
										<label class="d-block">Number of Visits</label>
										<input name="number_of_visits" type="number" step="1" value="{{ old('number_of_visits') ? old('number_of_visits') : 1 }}" class="form-control {{ $errors->has('number_of_visits') ? ' is-invalid' : '' }}"/>
										<div class="invalid-feedback">
											{{ $errors->first('number_of_visits') }}
										</div>
									</div>
									<div class="col-md-12 mb-3">
										<label class="d-block">Supply Length</label>
										<input name="supply_length" type="number" value="{{ old('supply_length') ? old('supply_length') : $drug_supply->supply_qty }}" class="form-control {{ $errors->has('supply_length') ? 'is-invalid' : '' }}">
										<div class="invalid-feedback">
											{{ $errors->first('supply_length') }}
										</div>
									</div>
								</div><!-- /.row -->
							</div>
							<div class="card-footer d-flex justify-content-center">
								<button class="btn btn-success" type="submit">
									<i class="far fa-check"></i>
									Save Changes
								</button>
							</div>
						@else
							<span>Drug distrobution schedule has not been set</span>
						@endif
					</div>
				</form>
			</div>
			<div class="col-lg-4 col-xl-8">
				<form action="{{ route('eac.portal.rid.supply.update') }}" method="post">
					@csrf
					<input type="hidden" name="rid_id" value="{{ $rid->id }}">
					@php $i = 1 @endphp
					@foreach($rid->shipmentsSorted() as $shipment)
						<div class="mb-3 shipment" data-id="{{$shipment->id}}">
							<div class="shipment-head">
								Shipment {{$i}} -
								<span class="shipment-date">
									{{$shipment->deliver_by_date ?? 'N/A'}}
								</span>
								<a class="delete-shipment-btn badge badge-danger" href="#" style="display: none">
									Delete
								</a>
							</div>
							<input type="hidden" name="shipments[{{$shipment->id}}]" value="1"/>
							<ul class="list-group connectedSortable" style="min-height: 25px; border: solid black 1px">
								@foreach($shipment->visits->sortBy('visit_date') as $visit)
									<li class="list-group-item ui-state-active visit">
										<input type="hidden" data-field="shipment_id" name="visits[{{$visit->id}}]" value="{{$shipment->id}}"/>
										Visit {{$visit->index}} -
										<span class="visit-date">{{$visit->visit_date}}</span>
									</li>
								@endforeach
							</ul>
						</div>
						@php $i++ @endphp
					@endforeach
					<button class="btn btn-success" type="submit">
						<i class="far fa-check"></i>
						Save Changes
					</button>
					<a class="text-white btn bg-gradient-indigo" href="#" onClick="window.location.reload();">
						<i class="far fa-times"></i>
						Cancel
					</a>
				</form>
			</div>
		</div>
	</div><!-- end .viewData -->
@endsection

@section('scripts')
	<script>
        $(function () {
            showBtns();
            $('.shipment-datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
                changeMonth: true,
                changeYear: true,
                minDate: '{{$rid->visits->sortBy('visit_date')->last()->visit_date}}',
                beforeShow: function (input, inst) {
                    var rect = input.getBoundingClientRect();
                    setTimeout(function () {
                        inst.dpDiv.css({top: rect.top + 40, left: rect.left + 0});
                    }, 0);
                }
            });
            $(".connectedSortable").sortable({
                connectWith: ".connectedSortable",
                stop: function (event, ui) {
                    // Set shipment_id of visit
                    let $shipment = ui.item.parent().parent();
                    ui.item.find("input[name^='visits']").val($shipment.data('id'));
                    showBtns();
                },
            }).disableSelection();

            function showBtns() {
                $('.shipment').each(function () {
                    if (!$(this).find('li').length)
                        $(this).find('.delete-shipment-btn').show();
                    else
                        $(this).find('.delete-shipment-btn').hide();
                });
            }

            $(".delete-visit-btn").click(function () {
                let $visit = $(this).parent();
                $visit.hide();
                $visit.find("input[name^='visit_active']").val(0);
                $visit.find("input[name^='visits']").remove();
            });
            $(".delete-shipment-btn").click(function () {
                let $shipment = $(this).parent().parent();
                $shipment.hide();
                $shipment.find("input[name^='shipments']").val(0);
            });
        });

        function ConfirmSubmit(e) {
            var r = confirm("Confirm sumbmission ?");
            if (r == true) {
                return true;
            } else {
                return false;
            }

            // e.preventDefault();
            //    swal({
            //        title: "Confirm submission",
            //        text: "Want to submit it",
            //        icon: "warning",
            //        buttons: [
            //            'No, cancel it!',
            //            'Yes, I am sure!'
            //        ],
            //        dangerMode: true,
            //    }).then(function (isConfirm) {
            //        if (isConfirm) {
            // 					 $(this).closest("form").submit();
            //        } else {
            //           return false;
            //        }
            //    })

        }
	</script>
@endsection
