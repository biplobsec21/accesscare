<div class="modal fade" id="Modal{{ $document->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.drug.doc.modal.update',$document->id) }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="document_id" value="{{$document->id}}"/>
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h4 class="m-0">
						Edit Form
     </h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="alert-secondary p-2 border-bottom">
					{{$document->type->name}}
				</div>
				<div class="modal-body p-3">
					<div class="row">
						<div class="col-lg mb-3">
							<label class="d-block label_required">Form Type</label>
							<select class="form-control type_id" name="type_id" required="required">
								<option selected="selected" value="{{$document->type_id}}">
									@php try{ echo $document->type->name; } catch (\Exception $e) {} @endphp
								</option>
								@foreach(\App\DocumentType::all()->sortBy('name') as $type)
									@unless($type->id == $document->type_id)
										<option value="{{$type->id}}">{{ $type->name }}</option>
									@endunless
								@endforeach
							</select>
						</div>
						<div class="col-lg-auto mb-3">
							<label class="d-block" for="activecheck">
								Status
							</label>
							<input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="secondary" data-width="100" name="active" {{ !empty($document) && ($document->active == '1' ) ? 'checked'  : '' }} />
						</div>
					</div>
					<div class="mb-3">
						<label class="d-block">Template <small>({{config('eac.storage.file.type')}})</small></label>
						@if($document->file_id)
       <div class="row flex-lg-nowrap">
        <div class="col col-lg-9">
									<div class="text-truncate">{!! $document->file->name !!}</div>
         <div class="small">
 									@include('include.portal.file-btns', ['id' => $document->file->id])
         </div>
								</div>
        <div class="col-auto col-lg text-lg-right">
         <a class="badge badge-danger" href="#" onclick="removeTemplate('{{$document->id}}', event)">
          <i class="far fa-times"></i> Remove
         </a>
								</div>
							</div>
						@else
							<div class="input-group m-0">
								<input class="form-control" type="file" name="template_file"/>
							</div>
       <label class="d-block small text-right">Maximum filesize: {{config('eac.storage.file.maxSize')}}</label>
						@endif
					</div>
					<div class="mb-3">
						<label class="d-block">Additional Information</label>
						<textarea class="form-control" rows="5" name="desc">{{$document->desc}}</textarea>
					</div>
     <div class="row">
      <div class="col-lg ">
       <strong class="d-block" for="reqCheck">
 							<span class="text-success">Initial Request</span> Requirements
 						</strong>
 						<input data-field="active" type="checkbox" data-toggle="toggle" data-off="Periodic" data-on="Required" data-onstyle="dark" data-offstyle="secondary" data-width="140" name="is_required" @if($document->is_required) checked @endif />
      </div>
      <div class="col-lg-5 ">
       <strong class="d-block" for="reqResCheck">
        <span class="text-warning">Resupply</span> Requirements
 						</strong>
 						<input data-field="active" type="checkbox" id="reqResCheck" name="is_required_resupply" data-toggle="toggle" data-off="Periodic" data-on="Required" data-onstyle="dark" data-offstyle="secondary" data-width="140" @if($document->is_required_resupply) checked @endif />
      </div>
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
