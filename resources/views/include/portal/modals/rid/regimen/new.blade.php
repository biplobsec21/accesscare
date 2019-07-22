<div class="modal fade" id="newRegimen{{$i}}Modal{{ $shipment->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.rid.edit.regimen.create') }}">
		@csrf
		<input type="hidden" name="rid_shipment_id" value="{{$shipment->id}}">
		<div class="modal-dialog modal-dialog-centered " role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
					Add Regimen for {{$component->name}}
					</h5>
					<input type="hidden" name="component_id" value="{{$component->id}}">
					<input type="hidden" name="shipment_id" value="{{$shipment->id}}">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body p-3">
					<div class="row">
						<div class="col-lg-7 col-xl-8 mb-3">
							<label class="d-block label_required">Dosage</label>
							<select id="lotSelect" name="drug_lot_id" class="form-control" required="required">
								<option disabled hidden selected value="">-- Select --</option>
								<option value="0">Not Applicable</option>
								@foreach(\App\DrugLot::allWithDrug($rid->drug_id) as $lot)
									@if($lot->dosage->component->id == $component->id && $lot->depot)
										<option value="{{ $lot->id }}">Lot: {{ $lot->number }}, {!!  $lot->dosage->display()  !!}</option>
									@endif
								@endforeach
							</select>
						</div>
						<div class="col-lg mb-3">
							<label class="d-block label_required">Amount to take</label>
							<div class="input-group">
								<input type="number" class="form-control" placeholder="#" name="quantity" step="0.01"
									   min="0">
								<div class="input-group-append">
									<span class="input-group-text">
										Doses
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="mb-3">
						<label class="d-block label_required">How often?</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text" style="min-width: 7rem">Every</span>
							</div>
							<input type="number" class="form-control" placeholder="#" name="frequency_1" step="0.01"
								   min="0">
							<select name="frequency_2" class="form-control" style="min-width: 12rem">
								<option disabled hidden selected value="">-- Select --</option>
								<option value="H">Hours</option>
								<option value="D">Days</option>
								<option value="W">Weeks</option>
								<option value="M">Months</option>
							</select>
						</div>
					</div>
					<div class="mb-3">
						<label class="d-block label_required">How long?</label>
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text" style="min-width: 7rem">For</span>
							</div>
							<input type="number" class="form-control" placeholder="#" name="length_1" step="0.01"
								   min="0">
							<select name="length_2" class="form-control" style="min-width: 12rem">
								<option disabled hidden selected value="">-- Select --</option>
								<option value="H">Hours</option>
								<option value="D">Days</option>
								<option value="W">Weeks</option>
								<option value="M">Months</option>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer p-2 d-flex justify-content-between">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
					<button type="submit" class="btn btn-success window-btn">
						Save
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
