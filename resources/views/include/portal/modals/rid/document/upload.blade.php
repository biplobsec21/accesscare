<div class="modal fade" id="FileUploadModal{{ $visitDocument->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.rid.modal.document.create') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="document_id" value="{{ $visitDocument->id }}"/>
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						Upload File </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				@if($visitDocument->required())
					<div class="alert alert-danger p-0 mb-0">
						<div class="row m-0">
							<div class="d-none d-md-block col-md-auto p-2">
								<i class="text-danger fas fa-info-circle fa-2x mt-1"></i>
							</div>
							<div class="col-md p-2">
								<div class="d-flex justify-content-between">
									<small class="d-block upper text-danger">Required File:</small>
									@if($visitDocument->template_file_id)
										@include('include.portal.file-btns', ['id' => $visitDocument->template_file_id])
									@endif
								</div>
								<strong class="d-block">{{$visitDocument->type->name}}</strong>
							</div>
						</div>
					</div>
				@else
					<div class="alert alert-info p-0 mb-0">
						<div class="row m-0">
							<div class="d-none d-md-block col-md-auto p-2">
								<i class="text-info fas fa-info-circle fa-2x"></i>
							</div>
							<div class="col-md p-2">
								<div class="d-flex justify-content-between">
									<small class="d-block upper text-info">Optional File:</small>
									@if($visitDocument->template_file_id)
										@include('include.portal.file-btns', ['id' => $visitDocument->template_file_id])
									@endif
								</div>
								<strong class="d-block">{{$visitDocument->type->name}}</strong>
							</div>
						</div>
					</div>
				@endif
				<ul class="list-group flex-lg-row align-items-lg-stretch">
					<li class="list-group-item flex-grow-1 mb-lg-0 border-light">
						<label class="d-block mb-1">Upload File <small>({{config('eac.storage.file.type')}})</small></label>
						<div class="input-group m-0">
							<input class="form-control" type="file" name="upload_file"/>
						</div>
      <label class="d-block small text-right">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
						<hr class="mt-3 mb-3"/>
						<label class="d-block">Notes</label>
						<textarea class="form-control" rows="2" name="desc"></textarea>
					</li>
				</ul>
				@if($visitDocument->type->desc)
					<div class="alert alert-secondary mb-0 p-2 small text-dark">
						<small class="d-block upper text-muted">Additional Information:</small>
						{!! $visitDocument->type->desc !!}
					</div>
				@endif
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
