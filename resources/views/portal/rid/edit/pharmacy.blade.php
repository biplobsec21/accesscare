@if($shipment)
	<div class="row">
		<div class="col-lg-6 col-xl-7">
			<h5 class="mb-3">
				Pharmacy
			</h5>
			@if($shipment->pharmacy)
				<div class="small mb-3">
					<strong class="d-block">{{ $shipment->pharmacy->name }}</strong>
					{!! $shipment->pharmacy->address->strDisplay() !!}
				</div>
			@else
				<div class="mb-3 text-muted">N/A</div>
			@endif
		</div>
		<div class="col-lg">
			<h5 class="mb-3">
				Pharmacist
			</h5>
			@if($shipment->pharmacist)
				{{ $shipment->pharmacist->name }}<br/>
				<i class="far fa-at"></i>
				<a target="_blank" href="mailto:{{ $shipment->pharmacist->email }}">
					{{ $shipment->pharmacist->email }}
				</a><br/>
				<i class="far fa-phone"></i>
				<a href="tel:{{ $shipment->pharmacist->getPhone() }}">
					{{ $shipment->pharmacist->getPhone() }}
				</a>
			@else
				<small class="text-muted">N/A</small>
			@endif
		</div>
	</div>
@endif
