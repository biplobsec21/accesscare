<div class="shadow-none card tab-pane fade" id="xship{{$shipment->id}}" role="tabpanel" aria-labelledby="xship{{$shipment->id}}-tab">
	<div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 d-flex justify-content-between">
		<div class="">
			<span class="text-upper">Shipment #{{$shipment_index}}</span>
		</div>
		<div class="">
			<a class="btn btn-light btn-sm" data-toggle="collapse" href=".multi-collapse" role="button"
			   aria-expanded="false"
			   aria-controls="details-1-{{$shipment->id}} details-2-{{$shipment->id}} details-3-{{$shipment->id}}">
				<span class="fal fa-angle-double-down heartBeat animated infinite slow"></span> Expand Information
			</a>
			<a class="btn btn-info btn-sm" href="{{route('eac.portal.rid.shipment.edit', $shipment->id)}}">
				Edit Shipment
			</a>
		</div>
	</div>
	@access('rid.shipment.view')
	<div class="pt-3 pl-3 pb-2 pr-3 alert-light text-dark border border-light">
		<div class="row">
			<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center mb-lg-0">
				<small class="upper d-block">Ship By</small>
				@if($visit->shipment->ship_by_date)
					<strong>{{\Carbon\Carbon::parse($visit->shipment->ship_by_date)->format(config('eac.date_format'))}}</strong>
				@else
					<span>N/A</span>
				@endif
			</div>
			<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center mb-lg-0">
				<small class="upper d-block">Shipped On</small>
				@if($visit->shipment->shipped_on_date)
					<strong>{{\Carbon\Carbon::parse($visit->shipment->shipped_on_date)->format(config('eac.date_format'))}}</strong>
				@else
					<span>N/A</span>
				@endif
			</div>
			<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center mb-lg-0">
				<small class="upper d-block">Delivered On</small>
				@if($visit->shipment->delivery_date)
					<strong>{{\Carbon\Carbon::parse($visit->shipment->delivery_date)->format(config('eac.date_format'))}}</strong>
				@else
					<span>N/A</span>
				@endif
			</div>
		</div>
	</div>
	@endif
	@access('rid.regimen.view')
	<div class="visitData pl-3 pr-3 mb-3 pt-3 mb-xl-4">
		<div class="row">
			<div class="col">
				<div class="h5 m-0">
					Regimen &amp; Frequency
				</div>
			</div>
			@if($rid->drug->components->count() > 0 )
				<div class="col-auto">
					<a class="btn btn-dark btn-sm" data-toggle="collapse"
					   href="#details-1-{{$shipment->id}}"
					   role="button" aria-expanded="false" aria-controls="details-1-{{$shipment->id}}">
						Show More
					</a>
				</div>
			@endif
		</div>
		<div class="row">
			<div class="col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
				@if(!$shipment->regimensNeeded()->count())
					<span class="badge badge-success ">
							<i class="fas fa-check"></i> Complete!
						</span>
				@else
					<span class="badge badge-danger">
							<i class="fas fa-exclamation-triangle"></i> Incomplete
						</span>
				@endif
			</div>
			<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
				<small class="upper d-block">Components</small>
				<strong>{{$rid->drug->components->count()}}</strong>
			</div>
			<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
				<small class="upper d-block">Regimens</small>
				<strong>{{$shipment ? $shipment->regimen->count() : '0'}}</strong>
			</div>
		</div>
		<div class="collapse multi-collapse" id="details-1-{{$shipment->id}}">
			<div class="table-responsive">
				<table class="table table-sm table-striped table-hover">
					<thead>
					<tr>
						<th>Component</th>
						<th>Regimen</th>
						<th>Depot</th>
						<th class="no-sort"></th>
					</tr>
					</thead>
					<tbody>
					@foreach($rid->drug->components->sortBy('index') as $component)
						<tr>
							<td>
								<span class="badge badge-outline-dark">{{$component->name}}</span>
							</td>
							@if($regimen = $shipment->regimenWithComponent($component->id))
								@if($regimen->is_applicable == 1)
									<td>
										<strong class="d-block">
											{{(int)$regimen->lot->dosage->amount * (int)$regimen->quantity}}{{$regimen->lot->dosage->unit->name}}
											{{$regimen->lot->dosage->form->name}}
										</strong>
										taken every {{$regimen->frequency}}
										for {{$regimen->length}}
										<small>({{ $regimen->lot->dosage->strength->name }})</small>
									</td>
									<td>
										@if($regimen->lot->depot)
											<span class="d-block">{{ $regimen->lot->depot->name }}</span>
										@endif
										@if($regimen->lot->number)
											<small>
												Lot:
												<span>{{ $regimen->lot->number }}</span>
											</small>
										@endif
									</td>
								@endif
								@if($regimen->is_applicable == 0)
									<td class="text-muted">N/A</td>
									<td class="text-muted">N/A</td>
								@endif
								<td class="text-right">
								</td>
							@else
								<td></td>
								<td></td>
								<td class="text-right">
								</td>
							@endif
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div><!-- /.visitData -->
	@endif
	@access('rid.pharmacy.view')
	<hr/>
	<div class="visitData pl-3 pr-3 mb-3 mb-xl-4">
		<div class="row">
			<div class="col">
				<div class="h5 m-0">
					Pharmacy
				</div>
			</div>
			<div class="col-auto">
				<a class="btn btn-dark btn-sm" data-toggle="collapse" href="#details-2-{{$shipment->id}}"
				   role="button" aria-expanded="false" aria-controls="details-2-{{$shipment->id}}">
					Show More
				</a>
			</div>
		</div>
		<div class="">
			<div class="row">
				<div class="col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
					@if($shipment->pharmacy && $shipment->pharmacist)
						<span class="badge badge-success">
								<i class="fas fa-check"></i> Complete!
							</span>
					@else
						<span class="badge badge-danger">
								<i class="fas fa-exclamation-triangle"></i> Incomplete
							</span>
					@endif
				</div>
				<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
					<small class="upper d-block">Pharmacy</small>
					@if($shipment->pharmacy)
						<strong>{{$shipment->pharmacy->name}}</strong>
					@else
						<small class="text-muted">N/A</small>
					@endif
				</div>
				<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
					<small class="upper d-block">Pharmacist</small>
					@if($shipment->pharmacist)
						<strong>{{$shipment->pharmacist->name}}</strong>
					@else
						<small class="text-muted">N/A</small>
					@endif
				</div>
			</div>
		</div>
		<div class="collapse multi-collapse" id="details-2-{{$shipment->id}}">
			<div class="row">
				<div class="col-sm-6 col-md-auto col-lg-4 mb-2">
					<label class="d-block">Pharmacy</label>
					@if($shipment->pharmacy)
						<div class="small">
							<span class="d-block font-italic">{{ $shipment->pharmacy->name }}</span>
							{!! $shipment->pharmacy->address->strDisplay()!!}
						</div>
					@else
						<span class="text-muted">N/A</span>
					@endif
				</div>
				<div class="col-sm-6 col-md-auto col-lg-4 mb-2">
					<label class="d-block">Pharmacist</label>
					@if($visit->shipment->pharmacist_id)
						<span class="d-block font-italic">{{ $shipment->pharmacist->name }}</span>
						<i class="fal fa-at"></i>
						<a target="_blank" href="mailto:{{ $visit->shipment->pharmacist->email }}">
							{{ $visit->shipment->pharmacist->email }}
						</a><br/>
						<i class="fal fa-phone"></i>
						<a href="tel:{{ $visit->shipment->pharmacist->getPhone() }}">
							{{ $visit->shipment->pharmacist->getPhone() }}
						</a>
					@else
						<small class="text-muted">N/A</small>
					@endif
				</div>
			</div>
		</div>
	</div>
	@endif
	@access('rid.shipment.view')
	@if($shipment)
		<hr/>
		<div class="visitData pl-3 pr-3 pb-3 mb-3 mb-xl-4">
			<div class="row">
				<div class="col">
					<div class="h5 m-0">
						Shipping Details
					</div>
				</div>
				<div class="col-auto">
					<a class="btn btn-dark btn-sm" data-toggle="collapse" href="#details-3-{{$shipment->id}}"
					   role="button" aria-expanded="false" aria-controls="details-3-{{$shipment->id}}">
						Show More
					</a>
				</div>
			</div>
			<div class="">
				<div class="row">
					<div class="col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
                        @if($shipment->ship_by_date && $shipment->deliver_by_date && $shipment->courier_id)
							<span class="badge badge-success ">
								<i class="fas fa-check"></i> Complete!
							</span>
						@else
							<span class="badge badge-danger">
								<i class="fas fa-exclamation-triangle"></i> Incomplete
							</span>
						@endif
					</div>
					<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
						<small class="upper d-block">Shipped On</small>
						@if($shipment->shipped_on_date)
							<strong>{{\Carbon\Carbon::parse($shipment->shipped_on_date)->format(config('eac.date_format'))}}</strong>
						@else
							<small class="text-muted">Not Shipped</small>
						@endif
					</div>
					<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
						<small class="upper d-block">Delivered On</small>
						@if($shipment->delivery_date)
							<strong>{{\Carbon\Carbon::parse($shipment->delivery_date)->format(config('eac.date_format'))}}</strong>
						@else
							<small class="text-muted">Not Delivered</small>
						@endif
					</div>
				</div>
			</div>
			<div class="collapse multi-collapse" id="details-3-{{$shipment->id}}">
				<div class="row">
					<div class="col-4 col-sm col-md-auto col-lg-3 mb-2">
						<label class="d-block">Ship By</label>
						@if($shipment->ship_by_date)
							{{\Carbon\Carbon::parse($shipment->ship_by_date)->format(config('eac.date_format'))}}
						@else
							<span class="text-muted">N/A</span>
						@endif
					</div>
					<div class="col-4 col-sm col-md-auto col-lg-3 mb-2">
						<label class="d-block">Expected Delivery</label>
						@if($shipment->deliver_by_date)
							{{\Carbon\Carbon::parse($shipment->deliver_by_date)->format(config('eac.date_format'))}}
						@else
							<span class="text-muted">N/A</span>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-4 col-sm col-md-auto col-lg-3 mb-2">
						<label class="d-block">Tracking Number</label>
						@if($shipment->tracking_number)
							{{ $shipment->tracking_number }}
						@else
							<span class="text-muted">N/A</span>
						@endif
					</div>
					<div class="col-4 col-sm col-md-auto col-lg-3 mb-2">
						<label class="d-block">Courier</label>
						@if($shipment->courier)
							{{ $shipment->courier->name }}
						@else
							<span class="text-muted">N/A</span>
						@endif
					</div>
				</div>
			</div>
		</div>
	@endif
	@endif
</div><!-- /.tab-pane -->
