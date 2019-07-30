<div class="modal fade" id="newLotModal" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.lot.store') }}">
		{{ csrf_field() }}
		<input type="hidden" name="go_back" value="1"/>
		<input type="hidden" name="drug_id" value="{{$drug->id}}"/>
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						Add Drug Lot </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body p-3">
					<div class="row">
						<div class="col-md mb-3">
							<label class="d-block label_required">Lot Number</label>
							<input type="text" name="number" class="form-control" required="required">
						</div>
						<div class="col-md mb-3">
							<label class="d-block label_required">Component and Dosage</label>
							<select name="dosage_id" class="form-control" required="required">
								<option disabled hidden selected value="">-- Select --</option>
								@foreach($drug->components as $component)
									<optgroup label=" {{ $component->name }}">
										@foreach($component->dosages as $dosage)
											@if($dosage->active == 1)
												<option value="{{ $dosage->id }}">
													{{ $dosage->form->name }} {{ $dosage->amount }}
													<small>{{ $dosage->unit->name }}</small>
												</option>
											@endif
										@endforeach
									</optgroup>
								@endforeach
							</select>
						</div>
					</div>
					<div class="mb-3">
						<label class="d-block label_required">Storage Depot</label>
						<select name="depot_id" class="form-control" required="required">
							<option disabled hidden selected value="">-- Select --</option>
							@foreach($depots as $depot)
								<option value="{{ $depot->id }}">{{ $depot->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="row">
						<div class="col-md mb-3">
							<label class="d-block label_required">Stock</label>
							<input type="number" name="stock" class="form-control" required="required">
						</div>
						<div class="col-md mb-3">
							<label class="d-block label_required">Minimum</label>
							<input type="number" name="minimum" class="form-control" required="required">
						</div>
					</div>
				</div>
				<div class="modal-footer p-2 d-flex justify-content-between">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
					<button type="submit" class="btn btn-success">
						Save
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
