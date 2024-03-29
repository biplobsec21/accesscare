<div class="modal fade" id="AddRedactedModal{{ $visitDocument->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.rid.modal.document.redacted') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="document_id" value="{{ $visitDocument->id }}"/>
		<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						Edit Uploaded Files </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				@if($visitDocument->required())
					<div class="alert alert-danger p-0 mb-0">
						<div class="row m-0">
							<div class="d-none d-md-block col-md-auto p-2">
								<i class="fas text-danger fa-info-circle fa-2x mt-1"></i>
							</div>
							<div class="col-md p-2">
								<small class="d-block upper text-danger">Required File:</small>
								<strong class="d-block">{{$visitDocument->type->name}}</strong>
								@if($visitDocument->template_file_id)
									@include('include.portal.file-btns', ['id' => $visitDocument->template_file_id])
								@endif
							</div>
						</div>
					</div>
				@else
					<div class="alert alert-info p-0 mb-0">
						<div class="row m-0">
							<div class="d-none d-md-block col-md-auto p-2">
								<i class="fas text-info fa-info-circle fa-2x"></i>
							</div>
							<div class="col-md p-2">
								<small class="d-block upper text-info">Periodic File:</small>
								<strong class="d-block">{{$visitDocument->type->name}}</strong>
								@if($visitDocument->template_file_id)
									@include('include.portal.file-btns', ['id' => $visitDocument->template_file_id])
								@endif
							</div>
						</div>
					</div>
				@endif
				<ul class="list-group flex-lg-row align-items-lg-stretch">
					<li class="list-group-item flex-grow-1 mb-lg-0 border-light">
						<div class="d-sm-flex justify-content-sm-between align-items-center">
							<label class="d-block upper mb-1">Uploaded File <small>({{config('eac.storage.file.type')}})</small></label>
							@if($visitDocument->file_id)
								<a class="btn btn-danger btn-sm" href="#" onclick="removeTemplateDocument('{{ $visitDocument->id }}', event,'upload_file')" data-toggle="tooltip" data-placement="bottom" title="Delete File">
									<i class="far fa-trash"></i>
									Delete
								</a>
							@endif
						</div>
						@if($visitDocument->file_id)
							@include('include.portal.file-btns', ['id' => $visitDocument->file_id])
						@else
							<div class="input-group m-0">
								<input class="form-control" type="file" name="upload_file" id="upload_file_{{ $visitDocument->id }}"/>
							</div>
       <label class="d-block small text-right">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
						@endif
						<hr class="mt-3 mb-3"/>
						<label class="d-block">Notes</label>
						@if($visitDocument->desc)
							{!! $visitDocument->desc !!}
						@else
							<small class="text-muted">N/A</small>
						@endif
					</li>
					<li class="list-group-item flex-grow-1 mb-lg-0 border-bottom border-light">
						<div class="d-sm-flex justify-content-sm-between align-items-center">
							<label class="d-block upper mb-1">Redacted File <small>({{config('eac.storage.file.type')}})</small></label>
							@if($visitDocument->redacted_file_id)
								<a class="btn btn-danger btn-sm" href="#" onclick="removeRedacted('{{$visitDocument->id}}', event)" data-toggle="tooltip" data-placement="bottom" title="Delete File">
									<i class="far fa-trash"></i>
									Delete
								</a>
							@endif
						</div>
						@if($visitDocument->redacted_file_id)
							@include('include.portal.file-btns', ['id' => $visitDocument->redacted_file_id])
						@else
							<div class="input-group m-0">
								<input class="form-control" type="file" id="new_template_{{ $visitDocument->id }}" name="redacted_file" required="required"/>
							</div>
       <label class="d-block small text-right">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
						@endif
						<hr class="mt-3 mb-3"/>
						<label class="d-block">Notes</label>
						@if($visitDocument->desc)
							{!! $visitDocument->desc !!}
						@else
							<textarea class="form-control form-control-sm" rows="2" name="desc">{{ $visitDocument->desc }}</textarea>
						@endif
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
