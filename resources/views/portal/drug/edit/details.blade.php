<div class="row">
    <div class="col-md-7 mb-3">
        <label class="d-block">Public Label</label>
        <input type="text" name="name" class="form-control" required="" value="{{ $drug->name }}">
    </div>
    <div class="col-md mb-3">
        <label class="d-block">Lab Name</label>
        <input type="text" name="lab_name" class="form-control" required="" value="{{ $drug->lab_name }}">
    </div>
</div><!-- /.row -->
<div class="row">
    <div class="col-md-7 mb-3">
        <label class="d-block">
            Manufactured By
        </label>
        <select class="form-control select2" name="company_id">
            <option value="{{ $drug->company_id }}">{{ $drug->company->name }}</option>
            @foreach($companies as $company)
                @unless($company->id = $drug->company_id)
                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                @endunless
            @endforeach
        </select>
    </div>
    <div class="col-md mb-3">
        <label class="d-block">Status</label>
        @if($drug->status == 'Approved')
            <span class="badge badge-success">
      Approved
    </span>
        @endif
        @if($drug->status == 'Pending')
            <span class="badge badge-warning">
      Pending
    </span>
        @endif
        @if($drug->status == 'Not Approved')
            <span class="badge badge-danger">
      Not approved
    </span>
        @endif
    </div>
</div><!-- /.row -->
<div class="mb-2">
    <label class="d-block">Internal Description</label>
    <textarea maxlength="3000" name="desc" class="form-control form-control-sm" rows="8">{{ $drug->desc }}</textarea>
</div>

{{-- <form method="post" action="{{ route('eac.portal.drug.description.update',$drug->id) }}" enctype="multipart/form-data">
	{{ csrf_field() }}
 <div class="modal fade" id="pubicDesc" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
   <div class="modal-content">
    <div class="modal-header border-0 p-2">
     <h5 class="m-0">
						Editing Public Description for <strong><u>{{ $drug->name }}</u></strong>
					</h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <div class="modal-body pt-0 pb-0 p-2">
     <textarea class="form-control editor" name="short_desc" rows="20">{{ $drug->short_desc }}</textarea>
				</div>
    <div class="modal-footer border-0 p-2 d-flex justify-content-between">
     <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="0">Cancel</button>
					<button type="submit"  class="btn btn-success">Save Changes</button>
				</div>
			</div>
		</div>
 </div><!-- /.modal -->
</form> --}}