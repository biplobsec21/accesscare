<div class="modal fade" id="Modal{{ $resource->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.drug.modal.resource.save') }}" enctype="multipart/form-data">
		{{csrf_field()}}
		<input type="hidden" name="drug_id" value="{{$drug->id}}"/>
		<input type="hidden" name="document_id" value="{{$resource->id}}"/>
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
    <div class="modal-header p-2">
     <h4 class="m-0">
						Edit Resource
					</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="alert-secondary p-2 border-bottom">
					{{$resource->name}}
				</div>
    <div class="modal-body p-3">
     <div class="row">
      <div class="col-lg mb-3">
       <label class="d-block label_required">Resource Name</label>
       <input class="form-control" type="text" name="name" value="{{$resource->name}}" required="required">
      </div>
      <div class="col-lg-auto mb-3">
       <label class="d-block" for="publiccheck">
        Audience
       </label>
       <input data-field="public" type="checkbox" data-toggle="toggle" data-off="Internal" data-on="Public" data-onstyle="success" data-offstyle="primary" data-width="120" name="public" @if($resource->public) checked="checked" @endif />
      </div>
     </div>
     <div class="row">
      <div class="col-lg mb-3">
       <label class="d-block label_required">Resource Type</label>
       <select class="form-control" name="type_id" required="required">
        <option selected="selected"
          value="{{ $resource->type->id }}">{{ $resource->type->name }}</option>
        @foreach(\App\DocumentType::where(['is_resource' => true])->get()->sortBy('name') as $type)
         @unless($type->id == $resource->type->id)
          <option value="{{$type->id}}">{{ $type->name }}</option>
         @endunless
        @endforeach
       </select>
      </div>
      <div class="col-lg-auto mb-3">
       <label class="d-block" for="activecheck">
        Status
       </label>
       <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="secondary" data-width="120" name="active" {{ !empty($resource) && ($resource->active == '1' ) ? 'checked'  : '' }} />
      </div>
     </div>
					<div class="mb-3">
						<label class="d-block label_required">Resource File <small>({{config('eac.storage.file.type')}})</small></label>
						@if($resource->file_id)
       <div class="row flex-lg-nowrap">
        <div class="col col-lg-9">
         <div class="text-truncate">{{$resource->file->name}}</div>
         <div class="small">
          @include('include.portal.file-btns', ['id' => $resource->file->id])
         </div>
        </div>
        <div class="col-auto col-lg text-lg-right">
         <a class="badge badge-danger" href="#" onclick="removeResource('{{$resource->id}}', event)">
										<i class="far fa-times"></i> Remove
									</a>
								</div>
       </div>
						@else
							<div class="input-group m-0">
								<input class="form-control" type="file" name="file_id" required="required" />
       </div>
       <label class="d-block small text-right">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
						@endif
					</div>
					<div class="">
						<label class="d-block">Additional Information</label>
						<textarea class="form-control" rows="5" name="desc">{{ $resource->desc }}</textarea>
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
