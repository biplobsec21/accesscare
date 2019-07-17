<div class="modal fade" id="newDrugUser" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.drug.modal.user.create') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="drug_id" value="{{$drug->id}}"/>
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
      Assign User to {{ $drug->name }}
					</h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <div class="modal-body p-3">
     <div class="mb-3">
						<label class="d-block">User</label>
						<select class="form-control" name="user_id">
							<option disabled hidden selected value="">-- Select --</option>
							@foreach($users as $user)
								<option value="{{$user->id}}">{{$user->full_name}}</option>
							@endforeach
						</select>
					</div>
     <div class="mb-2">
						<label class="d-block">Assign Role</label>
						<select class="form-control" name="role_id">
							<option disabled hidden selected value="">-- Select --</option>
							@foreach($roles as $role)
								<option value="{{$role->id}}">{{$role->name}}</option>
							@endforeach
						</select>
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
