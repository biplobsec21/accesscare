<div class="modal fade" id="Modal{{ $document->id }}" tabindex="-1" role="dialog" aria-hidden="true">
	<form method="post" action="{{ route('eac.portal.drug.doc.modal.update',$document->id) }}" enctype="multipart/form-data">
		{{ csrf_field() }}
		<input type="hidden" name="document_id" value="{{$document->id}}"/>
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						Edit Form </h5>
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
							<label class="d-block text-lg-center" for="activecheck">
								Active
								<span class="d-lg-block">
									<input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" data-width="100" data-height="32" name="active" {{ !empty($document) && ($document->active == '1' ) ? 'checked'  : '' }} />
								</span>
							</label>
						</div>
					</div>
					
					<div class="mb-3">
						<label class="d-block">Template</label>
						@if($document->file_id)
							<div class="row">
								<div class="col">
									{!! $document->file->name !!}
									@include('include.portal.file-btns', ['id' => $document->file->id])
								</div>
								<div class="col-auto">
									<a class="text-danger" href="#" onclick="removeTemplate('{{$document->id}}', event)" data-toggle="tooltip" data-placement="bottom" title="Delete File">
										<i class="fal fa-times"></i>
										<span class="sr-only">Delete</span>
									</a>
								</div>
							</div>
						@else
							<div class="input-group m-0">
								<input class="form-control" type="file" name="template_file"/>
							</div>
						@endif
					</div>
					<div class="mb-3">
						<label class="d-block">Additional Information</label>
						<textarea class="form-control" rows="5" name="desc">{{$document->desc}}</textarea>
					</div>
					<div class="mb-3">
						<label class="d-block" for="reqCheck">
							<strong class="text-success">Initial Requests</strong>
							<input data-field="active" type="checkbox" data-toggle="toggle" data-off="Periodic" data-on="Required" data-onstyle="success" data-offstyle="primary" data-width="105" data-height="32" name="is_required" @if($document->is_required) checked @endif />
						
						</label>
					</div>
					<div class="mb-3">
						<label class="d-block" for="reqResCheck">
							<strong class="text-warning">Resupplies</strong>
							<input data-field="active" type="checkbox" id="reqResCheck" name="is_required_resupply" data-toggle="toggle" data-off="Periodic" data-on="Required" data-onstyle="success" data-offstyle="primary" data-width="105" data-height="32" @if($document->is_required_resupply) checked @endif />
						
						</label>
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
