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
						<select id="pharmacySelect" name="pharmacy_id" class="select2 form-control">
							<option disabled hidden selected value="">-- Select --</option>
							<option value="new">
								New Pharmacy
							</option>
							@foreach($pharmacies as $pharmacy)
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
					<div class="card-footer d-flex justify-content-between p-2 align-items-center">
						<a href="#" class="btn btn-success window-btn" data-toggle="modal"
							data-target="#newPharmacistmodal">
							Add New Pharmacist
						</a>
						<a href="#" class="btn btn-primary" data-toggle="modal"
							data-target="#pharmacistaddmodal">
							Assign Pharmacist
						</a>
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
	<div class="modal fade" id="newPharmacistmodal" tabindex="-1" role="dialog" aria-hidden="true">
		<form method="post" action="{{ route('eac.portal.pharmacy.newpharmacist') }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="hidden" name="pharmacy_id" value="{{$pharmacy->id}}"/>
			<input type="hidden" name="country_name"
				value="{{$pharmacy->address && $pharmacy->address->country ? $pharmacy->address->country->id  : 0 }}"/>
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header p-2">
						<h5 class="m-0">
							New Pharmacist
						</h5>
						
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<i class="fal fa-times"></i>
						</button>
					</div>
					<div class="modal-body p-3">
						<table class="table table-sm table-striped table-hover">
							<thead>
							<tr>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th></th>
							</tr>
							</thead>
							<tbody id="memberSection">
							<tr class="">
								<td>
									<input type="text" name="name[]" placeholder="Pharmacist Name"
										class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
										required="required">
								</td>
								<td>
									<input type="email" name="email[]" placeholder="Email"
										class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
										required="required">
								</td>
								<td>
									<input type="text" name="phone[]" placeholder="Phone"
										class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"
										required="required">
								</td>
								<td>
								</td>
							</tr>
							</tbody>
						</table>
						
						
						<div class="d-flex justify-content-between mt-3">
							<a href="#" class="btn btn-link" id="addMemberBtn" onclick="addMember()">
								<i class="fal fa-plus"></i> Add Another
							</a>
						</div>
					</div>
					
					<div class="modal-footer p-2 d-flex justify-content-between">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel
						</button>
						<button type="submit" class="btn btn-success">
							Submit
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="modal fade" id="pharmacistaddmodal" tabindex="-1" role="dialog" aria-hidden="true">
		<form method="post" action="{{ route('eac.portal.pharmacy.assign.pharmacist') }}" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="hidden" name="pharmacy_id" value="{{$pharmacy->id}}"/>
			<div class="modal-dialog modal-dialog-centered modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header p-2">
						<h5 class="m-0">
							Select Pharmacist
						</h5>
						
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<i class="fal fa-times"></i>
						</button>
					</div>
					<div class="modal-body p-3">
						<div class="table-responsive">
							<table class="table  table-sm table-striped table-hover" id="pharmacistTBL">
								<thead>
								<tr>
									<th class="no-sort no-search">Select</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Pharmacy</th>
									<th>Created At</th>
								</tr>
								</thead>
								<tfoot>
								<tr>
									<th class="no-sort no-search">Select</th>
									<th>Name</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Pharmacy</th>
									<th>Created At</th>
								</tr>
								</tfoot>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
					
					<div class="modal-footer p-2 d-flex justify-content-between">
						<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel
						</button>
						<button type="submit" class="btn btn-success">
							Submit
						</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
