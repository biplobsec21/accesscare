<div class="modal fade" id="DrugModal{{ $rid->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.rid.modal.user.save') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="id" value="{{ $rid->id }}"/>
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
						Acknowledge Drug Confidentiality Agreement
     </h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <div class="modal-body p-3">
     <div class="mb-3">
      Confidential information specific to <strong>{{$rid->drug->name}}</strong> will be disclosed to you as supportive and instructional information. The information is confidential and is the sole property of <strong>{{$rid->drug->company->name}}</strong> Except as otherwise agreed to in writing, and by accepting or reviewing documents provided for the sole purpose of use outside of a clinical trial, you agree to hold this information in confidence and not copy, distribute or disclose the information contained in the documents.
     </div>
     <label class="d-block">
      <input type="checkbox" name="" value="" /> By checking this box I certify I have read the Drug Confidentiality Agreement and agree to its terms.
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
