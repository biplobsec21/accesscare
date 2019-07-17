<div class="modal fade" id="ConsentModal{{ $rid->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.rid.modal.user.save') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{ $rid->id }}"/>
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
      Patient Informed Consent
					</h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <div class="modal-body p-2">
     <label class="d-block">
      <input type="checkbox" name="" value="" /> By checking this box I certify that the patient has given consent to the receipt of the investigational drug.
     </label>
				</div>
    <div class="modal-footer p-2 d-flex justify-content-center">
     <button type="button" class="btn btn-secondary d-none" data-dismiss="modal" tabindex="-1">Cancel</button>
					<button type="submit" class="btn btn-success">
						Submit
					</button>
				</div>
			</div>
		</div>
	</form>
</div>
