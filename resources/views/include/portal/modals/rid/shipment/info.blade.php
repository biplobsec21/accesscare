<div class="modal fade" id="ShipmentInfoModal{{ $shipment->id }}">
	<form method="post" action="{{ route('eac.portal.rid.shipment.info.save') }}">
		@csrf
		<input type="hidden" name="id" value="{{ $shipment->id }}">
		<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						@if($shipment->courier)
							Edit
						@else
							Add
						@endif
						Shipping Courier
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body p-3">
					<div class="mb-3">
						<label class="d-block">Shipping Courier</label>
						<select class="form-control" name="courier_id">
							<option disabled hidden selected value="">-- Select --</option>
							@foreach($couriers as $courier)
								<option value="{{$courier->id}}"
									{{ $shipment && $shipment->courier && $shipment->courier->id == $courier->id ? 'selected' : ''}}>
									{{$courier->name}}
								</option>
							@endforeach
						</select>
					</div>
					<div class="">
						<label class="d-block">Tracking Number</label>
						<input type="text" class="form-control" name="tracking_number"
						       value="{{$shipment && $shipment->tracking_number ? $shipment->tracking_number : ''}}">
					</div>
				</div>
				<div class="modal-footer p-2 d-flex justify-content-between">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
					<button type="submit" class="btn btn-success window-btn">
						Save
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
