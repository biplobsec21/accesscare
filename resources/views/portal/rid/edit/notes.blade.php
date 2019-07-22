<h5 class="text-gold mb-2">
	Visit Notes
</h5>
<div class="row">
	<div class="col">
		<ul class="list-group list-group-flush m-0">
			@if($visit->notes->count())
				@foreach($visit->notes->sortByDesc('created_at') as $note)
					<li class="list-group-item pt-2 pl-0 pr-0 pb-2">
						<a href="{{ route('eac.portal.note.delete', $note->id) }}"
						   class="btn text-danger float-right"
						   title="Delete Note">
							<i class="far fa-times"></i> <span class="sr-only">Delete</span>
						</a>
						<label class="d-block">
							{{ $note->author->full_name ?? 'N/A' }}
							<small>{{ $note->created_at->format('Y-m-d h:m A') }}</small>
						</label>
						<p class="m-0">{{ $note->text }}</p>
					</li>
				@endforeach
			@else
				<p class="text-muted mb-0">
					<i class="fal fa-info-circle"></i> No information available
				</p>
			@endif
		</ul>
	</div>
	<div class="col-auto">
		@access('rid.note.create')
		<a href="#" class="btn btn-success btn-sm" data-toggle="modal"
		   data-target="#NoteAdd">
			Add Note to Visit
		</a>
		<div class="modal fade" id="NoteAdd" tabindex="-1" role="dialog" aria-hidden="true">
			<form method="post" action="{{ route('eac.portal.note.create') }}">
				{{ csrf_field() }}
				<input type="hidden" name="subject_id" value="{{$visit->id}}">
				<div class="modal-dialog modal-dialog-centered " role="document">
					<div class="modal-content">
						<div class="modal-header p-2">
							<h5 class="m-0">
								Add Note to <strong>Visit - {{ \Carbon\Carbon::parse($visit->visit_date)->format(config('eac.date_format')) }}</strong>
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
		@endaccess
	</div>
</div><!-- /.row -->
