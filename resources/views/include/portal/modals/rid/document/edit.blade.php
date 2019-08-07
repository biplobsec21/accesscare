<div class="modal fade" id="DocumentEditModal{{ $visitDocument->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.rid.modal.document.save') }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="document_id" value="{{ $visitDocument->id }}"/>
		<div class="modal-dialog @if(\Auth::user()->type->name == 'Early Access Care') modal-lg @endif modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						Edit Uploads </h5>
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
    <div class="row m-lg-0">
     <div class="col-lg p-3 border-right">
      <div class="mb-3">
       <label class="d-block">Uploaded File <small>({{config('eac.storage.file.type')}})</small></label>
       @if($visitDocument->file_id)
        <div class="row flex-lg-nowrap">
         <div class="col col-lg-9">
          <div class="text-truncate">{{$visitDocument->type->name}}</div>
          @if($visitDocument->file_id)
           <div class="small">
            @include('include.portal.file-btns', ['id' => $visitDocument->file_id])
           </div>
          @endif
         </div>
         <div class="col-auto col-lg text-lg-right">
          <a class="badge badge-danger" href="#" onclick="removeTemplateDocument('{{ $visitDocument->id }}', event,'upload_file')" data-toggle="tooltip" data-placement="bottom" title="Remove File">
           <i class="far fa-times"></i> Remove
          </a>
         </div>
        </div>
       @else
        <div class="input-group m-0">
         <input class="form-control" type="file" name="upload_file" id="upload_file_{{ $visitDocument->id }}"/>
        </div>
        <label class="d-block small text-right">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
       @endif
      </div>
     </div>
     <div class="col-lg p-3 border-right">
      asd
     </div>
    </div>
				<ul class="list-group flex-lg-row align-items-lg-stretch">
					@if(\Auth::user()->type->name == 'Early Access Care')
						<li class="list-group-item flex-grow-1 mb-lg-0 border-bottom border-light">
							<div class="d-sm-flex justify-content-sm-between align-items-center">
								<label class="d-block">Redacted File <small>({{config('eac.storage.file.type')}})</small></label>
								@if($visitDocument->redacted_file_id)
									<a class="badge badge-danger" href="#" onclick="removeTemplateDocument('{{$visitDocument->id}}', event,'redacted_file')">
										<i class="fas fa-times"></i>
										Delete
									</a>
								@endif
							</div>
							@if($visitDocument->redacted_file_id)
        <div class="small">
 								@include('include.portal.file-btns', ['id' => $visitDocument->redacted_file_id])
        </div>
							@else
								<div class="input-group m-0">
									<input class="form-control" type="file" id="new_template_{{ $visitDocument->id }}" name="redacted_file" required="required"/>
								</div>
        <label class="d-block small text-right">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
							@endif
							<hr class="mt-3 mb-3"/>
							<label class="d-block">Notes</label>
							<textarea class="form-control form-control-sm" rows="2" name="desc">{{ $visitDocument->desc }}</textarea>
						</li>
					@endif
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
