<div class="modal fade" id="inviteDrugUser" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.drug.modal.user.invite') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="drug_id" value="{{$drug->id}}"/>
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
   <div class="modal-content">
    <div class="modal-header p-2">
     <h5 class="m-0">
      Invite New User to {{ $drug->name }}
					</h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
    </div>
    <div class="modal-body p-3">
     <div class="row">
      <div class="col-md mb-3">
       <label class="d-block">First Name</label>
       <input type="text" class="form-control" name="first_name"/>
      </div>
      <div class="col-md mb-3">
       <label class="d-block">Last Name</label>
       <input type="text" class="form-control" name="last_name"/>
      </div>
     </div>
     <div class="mb-3">
      <label class="d-block">Email</label>
      <input type="text" class="form-control" name="email"/>      
     </div>
     <div class="">
						<label class="d-block">User Role</label>
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
						Send Invite
					</button>
				</div>

			</div>
		</div>
	</form>
</div>
