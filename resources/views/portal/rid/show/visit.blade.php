<div class="shadow-none card tab-pane fade" id="xdetails{{$visit->index}}"
     role="tabpanel"
     aria-labelledby="xdetails{{$visit->index}}-tab">
	<div class="bg-dark text-white pt-2 pb-2 pr-3 pl-3 pl-sm-0 d-flex justify-content-between">
		<div class="">
		<!-- <span class="text-upper">Viewing Visit #{{$visit->index}}</span> -->
			<span class="text-upper">Viewing Visit #{{$visit->index == 0 ? 1 : $visit->index}}</span>
			@if($visit->visit_date) -
			<strong>{{ \Carbon\Carbon::parse($visit->visit_date)->format(config('eac.date_format')) }}</strong> @endif
		</div>
		<div>
			<a class="btn btn-light btn-sm" data-toggle="collapse" href=".multi-collapse" role="button"
			   aria-expanded="false"
			   aria-controls="details-1-{{$visit->id}} details-2-{{$visit->id}} details-3-{{$visit->id}}">
				<span class="fal fa-angle-double-down heartBeat animated infinite slow"></span> Expand Information
			</a>
			@access('rid.visit.update')
			<a class="btn btn-info btn-sm" href="{{ route('eac.portal.rid.visit.edit', $visit->id) }}">
				<i class="far fa-edit"></i> Submit Required Documentation
			</a>
			@endif
		</div>
	</div>
	@access('rid.visit.view')
	<div class="pt-3 pl-3 pb-2 pr-3 alert-light text-dark border border-light">
		<div class="row">
			<div class="col-auto col-lg-3 mb-2 col-xl-auto text-lg-center mb-lg-0">
				<span class="badge badge-{{$visit->status->badge}}">{{ $visit->status->name }}:
					<small>{{ $visit->subStatus->name }}</small>
				</span>
			</div>
			<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center mb-lg-0">
				<small class="d-block upper">Visit Date</small>
				@if($visit->visit_date)
					<strong>{{ \Carbon\Carbon::parse($visit->visit_date)->format(config('eac.date_format')) }}</strong>
				@else
					<span class="text-secondary">N/A</span>
				@endif
			</div>
			<div class="col-auto col-lg-3 mb-2 col-xl-auto text-lg-center mb-lg-0">
				<small class="upper d-block">Assigned To</small>
				@if($visit->physician)
					<strong>{{$visit->physician->full_name}}</strong>
				@else
					<span class="text-secondary">N/A</span>
				@endif
			</div>
		</div>
	</div>
	@endif

	@access('rid.document.view')
	<div class="visitData pl-3 pr-3 mb-3 mb-xl-4">
		<div class="row">
			<div class="col">
				<div class="h5 m-0">
					Required Forms
				</div>
			</div>
			<div class="col-auto">
				<a class="btn btn-dark btn-sm" data-toggle="collapse" href="#details-2-{{$visit->id}}"
				   role="button" aria-expanded="false" aria-controls="details-2-{{$visit->id}}">
					Show More
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
				@if($visit->getDocStatus())
					<span class="badge badge-success ">
						<i class="fas fa-check"></i> Complete!
					</span>
				@else
					<span class="badge badge-danger ">
						<i class="fas fa-exclamation-triangle"></i> Incomplete
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
		<div class="collapse multi-collapse" id="details-2-{{$visit->id}}">
			<div class="table-responsive">
				<table class="table table-striped SOint table-sm">
					<thead>
					<tr>
						<th></th>
						<th>Form Type</th>
						<th colspan="2"></th>
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
								{{ $visitDocument->type->name }}
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
									<a href="#" data-toggle="modal" class="" title="Upload File"
									   data-target="#FileUploadModal{{ $visitDocument->id }}">
										<i class="@if(\Auth::user()->type->name == 'Physician') fas @else far @endif fa-upload"></i>
									</a>
									@endif
								@elseif(!$visitDocument->redacted_file_id)
									@access('rid.document.edit')
									<a href="#" data-toggle="modal" class="" title="Upload Redacted File"
									   data-target="#AddRedactedModal{{ $visitDocument->id }}">
										<i class="fas fa-upload text-primary"></i>
									</a>
									@endif
								@else
									@access('rid.document.edit')
									<a href="#" data-toggle="modal" class="" title="Edit Uploaded Files"
									   data-target="#DocumentEditModal{{ $visitDocument->id }}">
										<i class="far fa-fw fa-edit"></i>
									</a>
									@endif
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
		</div>
	</div>
	@endif
	@access('rid.note.view')
	<hr>
	<div class="visitData pl-3 pr-3 mb-3 pb-3 mb-xl-4">
		<div class="row">
			<div class="col">
				<span class="h5 m-0">
					Visit Notes
				</span>
			</div>
			<div class="col-auto">
				<a href="#" class="btn btn-success btn-sm" data-toggle="modal"
				   data-target="#NoteAdd{{$visit->id}}">
					Add Note to Visit
				</a>
			</div>
			<div class="col-auto">
				<a class="btn btn-dark btn-sm" data-toggle="collapse"
				   href="#details-4-{{$visit->id}}"
				   role="button" aria-expanded="false" aria-controls="details-4-{{$visit->id}}">
					Show More
				</a>
			</div>
		</div>
		<div class="">
			<div class="row">
				<div class="col-sm-3 col-lg-2 col-xl-auto mb-2">
					{{-- <small class="upper d-block">Total</small> --}}
					<span class="badge badge-primary">{{$visit->notes->count()}} Visit Notes</span>
				</div>
				<div class="col-sm-6 col-lg-7 col-xl-8 mb-2">
					<small class="upper d-block">Last Visit Note</small>
					@if($visit->notes->count())
						<div class="text-truncate">
							<strong>{{$visit->notes->sortByDesc('created_at')->first()->text}}</strong>
						</div>
					@endif
				</div>
				<div class="col-sm-3 col-xl mb-2">
					<small class="upper d-block">Added By</small>
					@if($visit->notes->count())
						<strong>{{$visit->notes->sortByDesc('created_at')->first()->author->full_name}}</strong>
					@endif
				</div>
			</div>
		</div>
		<div class="collapse multi-collapse" id="details-4-{{$visit->id}}">
			@if($visit->notes->count())
				<div class="mb-3">
					<ul class="list-group list-group-flush m-0">
						@foreach($visit->notes->sortByDesc('created_at') as $note)
							<li class="list-group-item pt-2 pl-0 pr-0 pb-2">
								<label class="d-block">
									<a href="{{ route('eac.portal.user.show', $note->author->id) }}">
										{{ $note->author->full_name ?? 'N/A' }}
									</a>
									<small>{{ $note->created_at->format('Y-m-d  h:m A') }}</small>
								</label>
								<p class="m-0">{{ $note->text }}</p>
							</li>
						@endforeach
					</ul>
				</div>
			@else
				<p class="text-muted mb-0">No Notes</p>
			@endif
		</div>
		<div class="modal fade" id="NoteAdd{{$visit->id}}" tabindex="-1" role="dialog" aria-hidden="true">
			<form method="post" action="{{ route('eac.portal.note.create') }}">
				{{ csrf_field() }}
				<input type="hidden" name="subject_id" value="{{$visit->id}}">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header p-2">
							<h5 class="m-0">
								Add Note to <strong>Visit {{ $visit->index }}</strong>
							</h5>
							<button type="button" class="close" data-dismiss="modal"
							        aria-label="Close">
								<i class="fal fa-times"></i>
							</button>
						</div>
						<div class="modal-body p-3">
							@if(\Auth::user()->type->name == 'Early Access Care')
								<label class="d-block">
									<input name="physican_viewable" type="checkbox" value="1" /> Viewable by Physician
								</label>
							@else
								<input name="physican_viewable" type="hidden" value="1" />
							@endif
							<label
								class="d-block">{{ \Auth::user()->first_name }} {{ \Auth::user()->last_name }}
								<small>{{date('Y-m-d H:i')}}</small>
							</label>
							<textarea name="text" class="note_text form-control" rows="3"
							          placeholder="Enter note..."></textarea>
						</div>
						<div class="modal-footer p-2 d-flex justify-content-between">
							<button type="button" class="btn btn-secondary"
							        data-dismiss="modal" tabindex="-1">Cancel
							</button>
							<button type="submit" name="submit" class="btn btn-success"
							        value="Add Note">Submit
							</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	@endif
</div><!-- /.tab-pane -->
