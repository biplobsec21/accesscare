<div class="modal fade" id="newPharmacyModal{{ $shipment->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.rid.pharmacy.set') }}">
		@csrf
		<input type="hidden" name="ship_id" value="{{ $shipment->id }}">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						Add Pharmacy
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body p-3">
					<div class="mb-3">
						<label class="d-block">Pharmacy</label>
						<select id="pharmacySelect" name="pharmacy_id" class="form-control">
                            <option disabled hidden selected value="">-- Select --</option>
							<option value="new">
								New Pharmacy
							</option>
							@foreach($pharmacies->sortBy('name') as $pharmacy)
								<option value="{{ $pharmacy->id }}">{{ $pharmacy->name }}</option>
							@endforeach
						</select>
					</div>
					<div id="oldPharmacy" class="collapse show mb-3">
						<div id="pharmaInfo" class="small"></div>
					</div>
					<div id="newPharmacy" class="collapse mb-3">
						<div class="mb-3">
							<label class="d-block">Pharmacy Name</label>
							<input type="text" name="pharmacy_name" placeholder="Pharmacy Name"
								   value="{{ ($shipment->pharmacy) ? ' ' : '' }}" class="form-control">
						</div>
						<div class="mb-3">
							<label class="d-block">Street Address</label>
							<input type="text" name="addr1" placeholder="Street Address" class="form-control mb-1">
							<input type="text" name="addr2" placeholder="Street Address (cont.)" class="form-control">
						</div>
						<div class="row">
							<div class="col-md mb-3">
								<label class="d-block">City</label>
								<input type="text" name="city" class="form-control">
							</div>
							<div class="col-md mb-3">
								<label class="d-block">State</label>
								<select name="state_province" class="form-control">
									<option disabled hidden selected value="">-- Select --</option>
									@foreach($states as $state)
										<option value="{{ $state->id }}">{{ $state->name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md mb-3">
								<label class="d-block">Country</label>
								<select name="country_id" class="form-control">
									<option disabled hidden selected value="">-- Select --</option>
									@foreach($countries as $state)
										<option value="{{ $state->id }}">{{ $state->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md mb-3">
								<label class="d-block">Postal Code</label>
								<input type="text" name="zipcode" class="form-control">
							</div>
						</div>
                        <hr/>
					</div>
                    <div id="choose-pharmacist" class="collapse mb-3">
                        <label class="d-block">Pharmacist</label>
                        <select id="pharmacistSelect" name="pharmacist_id" class="form-control">
                            <option disabled hidden selected value="">-- Select --</option>
                            <option value="new" data-pharmacy="*">New Pharmacist</option>
                            @foreach(App\Pharmacist::orderBy('name')->get() as $pharmacist)
                                <option value="{{ $pharmacist->id }}" data-pharmacy="{{$pharmacist->pharmacy->id ?? 'N/A'}}">{{ $pharmacist->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="newPharmacist" class="collapse mb-3">
                        <div class="mb-3">
                            <label class="d-block">Pharmacist Name</label>
                            <input type="text" name="pharmacist_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="d-block">Pharmacist Email</label>
                            <input name="pharmacist_email" type="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="d-block">Pharmacist Phone Number</label>
                            <input name="pharmacist_phone" type="text" class="form-control bfh-phone"
                                data-format="+1 (ddd) ddd-dddd">
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
