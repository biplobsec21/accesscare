<div class="modal fade" id="Modal{{ $dosage->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.drug.modal.dosage.save') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{$dosage->id}}"/>
		<div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
						Edit Component
					</h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <div class="modal-body p-3">
     <div class="mb-3">
      <label class="d-block">Dosage Form</label>
      <select class="form-control" name="form_id">
       <option selected="selected" value="{{ $dosage->form->id }}">{{ $dosage->form->name }}</option>
       @foreach(\App\DosageForm::all()->sortBy('name') as $form)
        @unless($form->id == $dosage->form->id)
         <option value="{{$form->id}}">{{ $form->name }}</option>
        @endunless
       @endforeach
      </select>
     </div>
     <div class="row">
      <div class="col-md mb-3">
       <label class="d-block">Component</label>
      </div>
      <div class="col-md mb-3">
       <div class="row m-0">
        <div class="col p-0">
         <label class="">Dose Strength</label>
         <input type="number" class="form-control" name="amount" step="any" value="{{ $dosage->amount }}">
        </div>
        <div class="col p-0">
         <label class="">Unit</label>
         <select class="form-control border-left-0 " name="unit_id">
          <option selected="selected" value="{{$dosage->unit->id}}">{{ $dosage->unit->name }}</option>
          @foreach(\App\DosageUnit::all()->sortBy('name') as $unit)
           @unless($unit->id == $dosage->unit->id)
            <option value="{{$unit->id}}">{{ $unit->name }}</option>
           @endunless
          @endforeach
         </select>
        </div>
       </div>
      </div>
     </div>
     <div class="row">
      <div class="col-md mb-3">
       <label class="d-block">Relevant Age Group</label>
       <select class="form-control" name="strength_id">
        <option selected="selected" value="{{$dosage->strength->id}}">{{ $dosage->strength->name }}</option>
        @foreach(\App\DosageStrength::all()->sortBy('name') as $strength)
         @unless($strength->id == $dosage->strength->id)
          <option value="{{$strength->id}}">{{ $strength->name }}</option>
         @endunless
        @endforeach
       </select>
      </div>
      <div class="col-md mb-3">
       <label class="d-block">Storage</label>
       <div class="input-group">
        <input type="text" class="form-control" name="temperature" value="{{ $dosage->temperature }}">
        <div class="input-group-append">
         <span class="input-group-text d-flex flex-column align-items-stretch text-dark">
          <small class="d-flex"><input type="radio" name="temp_opt" value="C" checked /> C</small>
          <small class="d-flex"><input type="radio" name="temp_opt" value="F" /> F</small>
         </span>
        </div>
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
