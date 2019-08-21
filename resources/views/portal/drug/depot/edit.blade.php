@extends('layouts.portal')

@section('title')
	Edit Depot
@endsection

@section('styles')
	<style>
		@media screen and (min-width: 1200px) {
			:root {
				--leftCol: 180px;
				--rightCol: 700px;
			}

			.actionBar, .viewData {
				max-width: calc(var(--leftCol) + var(--rightCol));
			}

			.viewData .row.thisone > [class*=col]:first-child {
				max-width: var(--leftCol);
				min-width: var(--leftCol);
			}

			.viewData .row.thisone > [class*=col]:last-child {
				max-width: var(--rightCol);
				min-width: var(--rightCol);
			}
		}
	</style>
@endsection

@section('content')
	<div class="titleBar">
		<nav aria-label="breadcrumb">
			<div class="row">
				<div class="col-sm-auto">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<a href="{{route('eac.portal.getDashboard')}}">Dashboard</a>
						</li>
						<li class="breadcrumb-item">
							<a href="{{route('eac.portal.depot.list.all')}}">All Depots</a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							@yield('title')
						</li>
					</ol>
				</div>
				<div class="d-none d-sm-block col-sm-auto ml-sm-auto">
					<div class="small">
						@if(!is_null($depot->updated_at))
							<strong>Last Updated:</strong>
							@php
								$time = $depot->updated_at;
								
								echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
							@endphp
						@endif
					</div>
				</div>
			</div>
		</nav>
		<h6 class="title small upper m-0">
			@yield('title')
		</h6>
		<h2 class="m-0">
			{{ $depot->name }}
		</h2>
		<div class="small d-sm-none">
			@if(!is_null($depot->updated_at))
				<strong>Last Updated:</strong>
				@php
					$time = $depot->updated_at;
					
					echo $time->setTimezone(Session::get('time-zone'))->format('Y/m/d h:i A');
				@endphp
			@endif
		</div>
	</div><!-- end .titleBar -->

	<div class="viewData">
		<form method="post" action="{{ route('eac.portal.depot.update', $depot->id) }}">
			{{ csrf_field() }}
			<input type="hidden" name="user_id" value="{{ \Auth::user()->id }}">
			<div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
				<a href="{{route('eac.portal.depot.list.all')}}" class="btn btn-light">
					Depots List
				</a>
				<div>
{{--					<button type="button" onclick="Confirm_Delete('{{ $depot->id }}')" class="btn btn-danger"--}}
{{--							title="Delete Depot">--}}
{{--						<i class="fas fa-times"></i> Delete--}}
{{--					</button>--}}
				</div>
			</div>
			<div class="row thisone m-0 mb-xl-5">
				<div class="col-sm-3 col-xl-auto mb-2 mb-sm-0 p-0">
					<div class="wizardSteps symbols nav flex-row flex-sm-column mt-sm-3" id="tab" role="tablist"
						 aria-orientation="vertical">
						<a class="nav-link complete active" id="xdetails-tab" data-toggle="pill" href="#xdetails"
						   role="tab" aria-controls="xdetails" aria-selected="true">
							<span>Details</span>
						</a>
						<a class="nav-link" id="xlots-tab" data-toggle="pill" href="#xlots" role="tab"
						   aria-controls="xlots" aria-selected="false">
							<span>Lots</span>
						</a>
					</div>
				</div>
				<div class="col-sm-9 col-xl p-0">
					<div class="card tab-content wizardContent" id="tabContent">
						<div class="alert-light text-dark pt-3 pl-3 pr-3">
							<div class="row">
								<div class="col-sm mb-3">
									<strong>{{ $depot->name }}</strong>
									@if($depot->address)
										<div class="small">
											{{ $depot->address->addr1 }}{{$depot->address->addr2 ? ', ' . $depot->address->addr2 : "" }}
											<br/>
											{{ $depot->address->city }},
											@if($depot->address->state){{  $depot->address->state->abbr }}@endif {{ $depot->address->zipcode }}
											, {{ $depot->address->country->name }}
										</div>
									@endif
								</div>
								<div class="col-sm col-xl-auto mb-3">
									<small class="upper d-block">Created On</small>
									<strong>{{ date('d M, Y', strtotime($depot->created_at))}}</strong>
								</div>
							</div>
						</div>
						<div class="tab-pane fade show active" id="xdetails" role="tabpanel"
							 aria-labelledby="xdetails-tab">
							<div class="card-body">
								<div class="mb-3">
									<label class="d-block label_required">Depot Name</label>
									<input type="text" name="depot_name" value="{{ $depot->name }}" class="form-control"
										   required="required">
								</div>
								<label class="d-block label_required">Address</label>
								<div class="row m-md-0">
									<div class="col-md mb-1 mb-md-3 p-md-0">
										<input type="text" name="depot_addr1"
											   value="{{ $depot->address && $depot->address->addr1 ? $depot->address->addr1 : '' }}"
											   class="form-control" required="required" placeholder="Street Address">
									</div>
									<div class="col-md-5 mb-3 p-md-0 pl-md-1">
										<input type="text" name="depot_addr2"
											   value="{{ $depot->address && $depot->address->addr2 ?  $depot->address->addr2 : ''}}"
											   class="form-control" placeholder="Building, Suite, Floor, etc">
									</div>
								</div>
								<div class="row">
									<div class="col-md-7 col-lg mb-3">
										<label class="d-block label_required">Country</label>
										<select name="depot_country_id" class="form-control select2" id="country_id"
												required="required">
											<option disabled hidden selected value="">-- Select --</option>
											@foreach($countries as $country)
												@if ($depot->address->country->id == $country->id)))
												<option value="{{ $country->id }}"
														selected>{{ $country->name }}</option>
												@else
													<option value="{{ $country->id }}">{{ $country->name }}</option>
												@endif
											@endforeach
										</select>
									</div>
									<div class="col-md-5 col-lg-3 mb-3">
										<label class="d-block label_required">City</label>
										<input type="text" name="depot_city"
											   value="{{ $depot->address && $depot->address->city ? $depot->address->city : ''}}"
											   class="form-control" required="required">
									</div>
									<div class="col-sm-7 col-lg mb-3">
										<label class="d-block label_required" id="lbl">State</label>
										<select name="depot_state_province" class="form-control" id="state"
												required="required">
											@if($depot->address->state_province)
												<option
													value="{{$depot->address && $depot->address->state_province ? $depot->address->state_province : '' }}"
													selected>{{$depot->address && $depot->address->state->name ? $depot->address->state->name : ''}}</option>
											@else
												<option disabled hidden selected value="">-- Select --</option>
											@endif
											@foreach($states as $state)
												@unless($state->id == $depot->address->state_province)
													<option value="{{ $state->id }}">{{ $state->name }}</option>
												@endunless
											@endforeach
										</select>
									</div>
									<div class="col-sm-5 col-lg-3 mb-3">
										<label class="d-block label_required">Postal Code</label>
										<input type="text" name="depot_zip"
											   value="{{ $depot->address && $depot->address->zipcode ? $depot->address->zipcode : '' }}"
											   class="form-control" required="required">
									</div>
								</div>
							</div>
							<div class="card-footer d-flex justify-content-end">
								<button class="btn btn-success " type="submit">
									<i class="far fa-check"></i> Update
								</button>
							</div>
						</div>
						<div class="tab-pane fade" id="xlots" role="tabpanel" aria-labelledby="xlots-tab">
							<div class="card-body">
								<h5 class="mb-3">
									Lots
								</h5>
								<div class="table-responsive">
									<table class="table  table-sm table-striped table-hover" id="lotlist">
										<thead>
										<tr>
											<th>Lot Number</th>
											<th>Drug</th>
											<th>Dosage</th>
											<th>Stock</th>
											<th>Created At</th>
											<th></th>
										</tr>
										</thead>
										<tbody>
											@foreach($depot->lots->sortBy('number') as $lot)
												
												<tr>
													<td>{{$lot->number}}</td>
													<td>
														<a href="{{$lot->dosage->component->drug->view_route}}">
															{{$lot->dosage->component->drug->name}}
														</a>
													</td>
													<td>{!! $lot->dosage->display_short !!}</td>
													<td>{{$lot->stock}}</td>
													<td>{{$lot->updated_at->format(config('eac.date_format'))}}</td>
													<td>
														<a title="Edit Lot" href="{{route('eac.portal.lot.edit', $lot->id) . '?depot=' . $depot->id}}">
															<i class="far fa-edit" aria-hidden="true"></i> <span class="sr-only">Edit Lot</span>
														</a>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class="card-footer d-flex justify-content-end p-2">
								<a href="{{ route('eac.portal.lot.create') . '?depot=' . $depot->id}}"
								   class="btn btn-success">
									<i class="fa-fw fal fa-container-storage"></i> Add Lot
								</a>
							</div>
						</div>
					</div>
				</div>
			</div><!-- /.row -->
		</form>
	</div>
@endsection

@section('scripts')

	<script type="text/javascript">
		if ($("#country_id option:selected").text() == 'United States') {
			$("#state").prop('required', true);
			$("#lbl").addClass('label_required');
		} else {
			$("#state").prop('required', false);
			$("#lbl").removeClass('label_required');

		}

		$("#country_id").on('change', function () {
			if ($("#country_id option:selected").text() == 'United States') {
				$("#state").prop('required', true);
				$("#lbl").addClass('label_required');
			} else {
				$("#state").prop('required', false);
				$("#lbl").removeClass('label_required');
			}

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
						$.get("{{route('eac.portal.depot.remove')}}",
							{
								id: param
							});
						// return false;
						swal.close();

						$(location).attr('href', '{{route('eac.portal.depot.list.all')}}');
					});
				} else {
					swal("Cancelled", "Operation cancelled", "error");
				}
			})
		}
	</script>
@endsection
