<div class="modal fade" id="Modal{{ $state->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
  <div class="modal-content">
   <div class="modal-header p-2">
    <h5 class="m-0">
					Edit Note
				</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
     <i class="fal fa-times"></i>
    </button>
   </div>
			<div class="modal-body p-3">
				<div class="row">
					<div class="col-md-12 m-b-10">
						<label class="d-block">Note</label>
						<textarea class="form-control" name="notes" rows="10">{{ $state->note }}</textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer p-2 d-flex justify-content-between">
    <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
				<button type="button" class="btn btn-success">
					Save
				</button>
			</div>
		</div>
	</div>
</div>
