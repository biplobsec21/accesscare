<div class="modal fade" id="addDrugTeam" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.drug.modal.group.save') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="modal-dialog modal-dialog-centered modal-sm" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						Assign Group to Drug
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body p-3">
					<div class="mb-3">
						<label class="d-block label_required">User Group</label>
						<select class="form-control" name="user_group_id" required="required">
							<option disabled hidden selected value="">-- Select --</option>
							@foreach($groups as $group)
								<option value="{{$group->id}}">{{$group->name}}</option>
							@endforeach
						</select>
						<input type="hidden" name="drug_id" value="{{ $drug->id }}"/>
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
