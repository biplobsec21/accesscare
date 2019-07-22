<div class="modal fade" id="ShipmentDateModal{{ $shipment->id }}">
	<form method="post" action="{{ route('eac.portal.rid.shipment.dates.save') }}">
		@csrf
		<input type="hidden" name="id" value="{{ $shipment->id }}">
		<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						@if($shipment->ship_by_date || $shipment->deliver_by_date || $shipment->shipped_on_date || $shipment->delivery_date)
							Edit
						@else
							Set
						@endif
						Dates
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="alert-info">
					<div class="row m-0">
						<div class="col-auto p-2 align-items-center justify-content-center d-flex bg-info text-white">
							<i class="fas fa-info-circle"></i>
						</div>
						<div class="col p-2 small">
							Enter dates in <strong>YYYY-MM-DD</strong> format
						</div>
					</div>
				</div>
				<div class="modal-body p-3">
					<div class="row">
						<div class="col-xl-12">
							<div class="row">
								<div class="col-xl-12 mb-3">
									<label class="d-block">Ship By</label>
									<input type="text" class="datepicker form-control" name="ship_by_date"
									       value="{{ $shipment->ship_by_date }}">
								</div>
								<div class="col-xl-12 mb-3">
									<label class="d-block">Expected Delivery</label>
									<input type="text" class="datepicker form-control" name="deliver_by_date"
									       value="{{ $shipment->deliver_by_date }}">
								</div>
							</div>
						</div>
						<div class="col-xl-12">
							<hr class="mt-0"/>
							<div class="row">
								<div class="col-xl-12 mb-3">
									<label class="d-block">Shipped On</label>
									<input type="text" class="datepicker form-control" name="shipped_on_date"
									       value="{{ $shipment->shipped_on_date }}">
								</div>
								<div class="col-xl-12 mb-3 mb-xl-0">
									<label class="d-block">Delivered On</label>
									<input type="text" class="datepicker form-control" name="delivery_date"
									       value="{{ $shipment->delivery_date }}">
								</div>
							</div>
						</div>
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
