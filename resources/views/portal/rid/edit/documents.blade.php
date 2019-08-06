<div class="visitData">
	<div class="row">
		<div class="col">
			<h5 class="mb-0">
				Required Forms </h5>
		</div>
		<div class="col-auto">
			@access('rid.document.update')
			<a href="#editReqForms" data-toggle="modal" class="btn btn-info btn-sm">
				<i class="fal fa-edit"></i>
				Edit Forms
			</a>
			<form method="post" action="{{ route('eac.portal.rid.document.required.update') }}">
				@csrf
				<div class="modal fade" id="editReqForms" tabindex="-1" role="dialog" aria-labelledby="editReqFormsLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-header p-2">
								<h5 class="m-0">
									Edit Forms </h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<i class="fal fa-times"></i>
								</button>
							</div>
							<div class="modal-body p-3">
								<div class="table-responsive">
									<table class="table table-striped SOint table-sm ">
										<thead>
										<tr>
											<th class="text-center">Required</th>
											<th>Form Type</th>
										</tr>
										</thead>
										<tbody>
										@foreach($visit->documents as $document)
											<tr class="">
												<td class="text-center">
													<input type="hidden" name="doc[{{$document->id}}]" value="0"/>
													<input type="checkbox" name="doc[{{$document->id}}]" value="1" @if($document->required()) checked @endif />
												</td>
												<td>
													{{ $document->type->name }}
												</td>
											</tr>
										@endforeach
										</tbody>
									</table>
								</div>
							</div>
							<div class="modal-footer p-2 d-flex justify-content-between">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">
									Cancel
								</button>
								<button type="submit" class="btn btn-success">
									Save
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
			@if($visit->getDocStatus())
				<span class="badge badge-success ">
					<i class="fas fa-check"></i>
					Complete!
				</span>
			@else
				<span class="badge badge-danger ">
					<i class="fas fa-exclamation-triangle"></i>
					Incomplete
				</span>
			@endif
		</div>
		<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
			<small class="upper d-block">Total</small>
			<strong>{{$visit->documents->count()}}</strong>
		</div>
		<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
			<small class="upper d-block">Required</small>
			<strong>{{$visit->requiredDocs()->count()}}</strong>
		</div>
		<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
			<small class="upper d-block">Uploaded</small>
			<strong>{{$visit->uploadedDocuments()->count()}}</strong>
		</div>
	</div>
	
	<div class="table-responsive">
		<table class="table table-striped SOint table-sm ">
			<thead>
			<tr>
				<th></th>
				<th>Form Type</th>
				<th colspan="3"></th>
			</tr>
			</thead>
			<tbody>
			@foreach($visit->documents as $visitDocument)
				<tr>
					<td class="text-center">
						@if($visitDocument->file_id)
							@if($visitDocument->redacted_file_id)
								<span class="text-success fas fa-check-circle fa-sm"></span>
							@else
								<span class="text-info fal fa-check fa-xs"></span>
							@endif
						@elseif($visitDocument->required())
							<span class="text-danger fas fa-exclamation-triangle fa-sm"></span>
						@endif
					</td>
					<td>
						{{ $visitDocument->type->name ?? ''}}
						@if($visitDocument->template_file_id)
							@include('include.portal.file-btns', ['id' => $visitDocument->template_file_id])
						@endif
					</td>
					<td class="text-center">
						@if($visitDocument->required())
							<span class="badge badge-outline-dark">Required</span>
						@else
							<span class="badge badge-outline-secondary">Periodic</span>
						@endif
					</td>
					<td class="text-right">
						@if(!$visitDocument->file_id)
							@access('rid.document.create')
							<a href="#" data-toggle="modal" class="" title="Upload File" data-target="#FileUploadModal{{ $visitDocument->id }}">
								<i class="@if(\Auth::user()->type->name == 'Physician') fas @else far @endif fa-upload"></i>
							</a>
						@endif
						@elseif(!$visitDocument->redacted_file_id)
							@access('rid.document.update')
							<a href="#" data-toggle="modal" class="" title="Upload Redacted File" data-target="#AddRedactedModal{{ $visitDocument->id }}">
								<i class="fas fa-upload text-primary"></i>
							</a>
						@endif
						@else
							<a href="#" data-toggle="modal" class="" title="Edit Uploaded Files" data-target="#DocumentEditModal{{ $visitDocument->id }}">
								<i class="far fa-fw fa-edit"></i>
							</a>
						@endif
					</td>
				</tr>
				@if(!$visitDocument->file_id)
					@include('include.portal.modals.rid.document.upload')
				@else
					@include('include.portal.modals.rid.document.redacted')
					@include('include.portal.modals.rid.document.edit')
				@endif
			@endforeach
			</tbody>
		</table>
	</div>
	
	@php $drug = \App\DRUG::where('id','=',$rid->drug->id)->firstOrFail() @endphp
	@access('rid.document.update')
	<div class="mt-3">
		<button type="button" class="btn btn-success window-btn" data-toggle="modal" data-target="#newDocumentModal">
			<i class="fal fa-plus"></i>
			New Form
		</button>
	</div>
	@include('include.portal.modals.rid.document.new')
	@endif
</div>
