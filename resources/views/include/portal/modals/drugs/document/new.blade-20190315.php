<div class="modal fade" id="newDocumentModal">
	<form method="post" action="{{ route('eac.portal.drug.modal.document.create') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header p-10">
					<div>
						<h5 class="upper m-0">
							New File
						</h5>
						<input type="hidden" name="drug_id" value="{{$drug->id}}"/>
					</div>
					<button type="button" class="close" data-dismiss="modal" aria-strong="Close">
			<span aria-hidden="true">
			<i class="far fa-times"></i>
			</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12 m-b-10">
							<strong class="d-block">File Type</strong>
							<select class="custom-select" name="type_id" id="type_id">
								<option value="">-- Select --</option>
								@foreach(\App\DocumentType::all()->sortBy('name') as $type)
									<option value="{{$type->id}}">{{ $type->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-md-9 m-b-10">
							<strong class="d-block">Blank File</strong>
							<input class="form-control" type="file" name="template_file" value="0"/>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 m-b-10">
							<strong class="d-block">Active</strong>
							<input class="form-control" type="checkbox" name="active"/>
						</div>
						<div class="col-md-4 m-b-10">
							<strong class="d-block">Always Required</strong>
							<input class="form-control" type="checkbox" name="is_required"/>
						</div>
						<div class="col-md-4 m-b-10">
							<strong class="d-block">Required on Resupply</strong>
							<input class="form-control" type="checkbox" name="is_required_resupply"/>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 m-b-10">
							<strong class="d-block">Additional Information</strong>
							<textarea class="form-control" rows="5" name="desc"></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
						<button type="submit" class="btn btn-success">
							Save
						</button>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
