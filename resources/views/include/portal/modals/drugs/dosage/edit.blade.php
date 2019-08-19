<div class="modal fade" id="DosageModal{{ $dosage->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.drug.modal.dosage.save') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{$dosage->id}}"/>
		<input type="hidden" name="modal_id" value="DosageModal{{ $dosage->id }}"/>
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						Edit Dosage
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body p-3">
					<div class="row">
					<div class="col-md mb-3">
						<label class="d-block label_required">Dosage Form</label>
						<select class="form-control {{ $errors->has('form_id') ? ' is-invalid' : '' }}" name="form_id" required="required">
							<option selected="selected"
									value="{{ $dosage->form->id }}">{{ $dosage->form->name }}</option>
							@foreach(\App\DosageForm::all()->sortBy('name') as $form)
								@unless($form->id == $dosage->form->id)
									<option value="{{$form->id}}">{{ $form->name }}</option>
								@endunless
							@endforeach
						</select>
						<div class="invalid-feedback">
				     {{ $errors->first('form_id') }}
				   </div>
					</div>
					<div class="col-sm-auto mb-3">
         <label class="d-block">Status</label>
									<input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" data-width="100" data-height="32" name="active" {{ $dosage->active == '1' ? 'checked'  : '' }} />     </div>
    </div>
					<div class="row">
						<div class="col-md mb-3">
							<label class="d-block label_required">Component</label>
							<select class="form-control" name="component_id" required="required">
								@foreach($drug->components as $component)
									<option value="{{ $component->id }}"
											@if($dosage->component->id == $component->id) selected @endif>
										{{ $component->name }}</option>
								@endforeach
							</select>
						</div>
						<div class="col-md mb-3">
							<div class="row m-0">
								<div class="col p-0">
									<label class="label_required">Dose Strength</label>
									<input type="number" class="form-control {{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" step="any"
										   value="{{ $dosage->amount }}" required="required">
								   <div class="invalid-feedback">
						           {{ $errors->first('amount') }}
						          </div>
								</div>
								<div class="col p-0">
									<label class="label_required">Unit</label>
									<select class="form-control border-left-0 label_required {{ $errors->has('unit_id') ? ' is-invalid' : '' }}" name="unit_id" required="required">
										<option selected="selected"
												value="{{$dosage->unit->id}}">{{ $dosage->unit->name }}</option>
										@foreach(\App\DosageUnit::all()->sortBy('name') as $unit)
											@unless($unit->id == $dosage->unit->id)
												<option value="{{$unit->id}}">{{ $unit->name }}</option>
											@endunless
										@endforeach
									</select>
									<div class="invalid-feedback">
							           {{ $errors->first('unit_id') }}
						     </div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md mb-3">
							<label class="d-block label_required">Relevant Age Group</label>
							<select class="form-control {{ $errors->has('strength_id') ? ' is-invalid' : '' }}" name="strength_id" required="required">
								<option selected="selected"
										value="{{$dosage->strength->id}}">{{ $dosage->strength->name }}</option>
								@foreach(\App\DosageStrength::all()->sortBy('name') as $strength)
									@unless($strength->id == $dosage->strength->id)
										<option value="{{$strength->id}}">{{ $strength->name }}</option>
									@endunless
								@endforeach
							</select>
							<div class="invalid-feedback">
					     {{ $errors->first('strength_id') }}
					   </div>
						</div>
						<div class="col-md mb-3">
							<label class="d-block label_required">Storage</label>
       <div class="input-group">
 							<input type="text" class="form-control {{ $errors->has('temperature') ? ' is-invalid' : '' }}" name="temperature" value="{{ $dosage->temperature }}" required="required">
        <div class="input-group-append">
         <span class="input-group-text d-flex flex-column align-items-stretch text-dark">
          <small class="d-flex"><input type="radio" name="temp_opt" value="C" checked /> C</small>
          <small class="d-flex"><input type="radio" name="temp_opt" value="F" /> F</small>
         </span>
        </div>
       </div>
				   <div class="invalid-feedback">
        {{ $errors->first('temperature') }}
       </div>
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
