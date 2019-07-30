<div class="modal fade" id="LetterModal{{ $rid->id }}" tabindex="-1" role="dialog" aria-hidden="true">
 <form method="post" action="{{ route('eac.portal.rid.modal.user.save') }}" enctype="multipart/form-data">
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $rid->id }}"/>
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
      Submit Signed Physician Agreement Letter
     </h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <div class="alert-secondary p-2 border-bottom mono">
     {{$rid->number}}
    </div>
    <div class="modal-body p-3">
     <div class="mb-3">
      <label class="d-block mb-1">Attach Document <small>({{config('eac.storage.file.type')}})</small></label>
      <label class="d-block"><small>Maximum filesize: {{config('eac.storage.file.maxSize')}}</small></label>
      <div class="input-group">
       <input type="file" class="form-control" name="" value="filename.extension" />
      </div>

      @ if document has been uploaded
      <div class="row">
       <div class="col-sm">
        filename.extension
       </div>
       <div class="col-sm-auto">
        <a class="btn btn-danger btn-sm" href="#" onclick="removeTemplateDocument3('{{$rid->id}}',event)">
         <i class="far fa-times"></i> Delete
        </a>
       </div>
      </div>
     </div>
     <div class="">
      <label class="d-block">Notes</label>
      <textarea class="form-control" rows="3" name=""></textarea>
     </div>
    </div>
    <div class="modal-footer p-2 d-flex justify-content-between">
     <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
     <button type="submit" class="btn btn-success">
      Cancel
     </button>
    </div>
   </div>
  </div>
 </form>
</div>

<div class="modal fade" id="ReviewLetterModal{{ $rid->id }}" tabindex="-1" role="dialog" aria-hidden="true">
 <form method="post" action="{{ route('eac.portal.rid.modal.user.save') }}" enctype="multipart/form-data">
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $rid->id }}"/>
  <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
      Signed Physician Agreement Letter Review
     </h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <div class="alert-secondary p-2 border-bottom text-center">
     <a href="#">
      <i class="fas fa-download text-muted"></i> Uploaded File
     </a>
    </div>
    <div class="modal-body p-3">
     <div class="mb-3">
      <div class="row">
       <div class="col-sm-auto">
        <label class="d-sm-block mb-1">
         <input type="radio" name="align" value="yes" /> Yes
        </label>
        <label class="d-sm-block">
         <input type="radio" name="align" value="no" /> No
        </label>
       </div>
       <div class="col-sm">
        Does the Signed Physician Agreement Letter document match with the corresponding drug, physician and patient?
       </div>
      </div>
     </div>
     <hr class="mt-0" />
     <div class="row">
      <div class="col-md mb-3">
       <label class="d-block">Record #</label>
       <input type="text" value="" name="" class="form-control" />
      </div>
      <div class="col-md mb-3">
       <label class="d-block">Expiration Date <small>(YYYY-MM-DD)</small></label>
       <input type="text" value="" name="" class="form-control" />
      </div>
     </div>
     <div class="">
      <label class="d-block">Notes</label>
      <textarea class="form-control" rows="3" name=""></textarea>
     </div>
    </div>
    <div class="modal-footer p-2 d-flex justify-content-between">
     <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
     <button type="submit" class="btn btn-success">
      Cancel
     </button>
    </div>
   </div>
  </div>
 </form>
</div>
