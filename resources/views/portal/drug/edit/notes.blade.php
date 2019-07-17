<div class="card mb-0">
	<div class="card-body pt-2">
  <h5 class="">
   Notes &amp; Correspondence
   <span class="badge badge-dark">{{$drug->notes->count()}}</span>
  </h5>
		@access('drug.note.create', $drug->id)
			@if($drug->notes->count())
				<ul class="list-group list-group-flush m-0">
					@foreach($drug->notes->sortByDesc('created_at') as $note)
						<li class="list-group-item pt-2 pl-0 pr-0 pb-2">
							<a href="{{ route('eac.portal.note.delete', $note->id) }}"
							   class="btn text-danger float-right" title="Delete Note">
								<i class="far fa-times"></i> <span class="sr-only">Delete</span>
							</a>
							<label class="d-block">
								<a href="{{ route('eac.portal.user.show', $note->author->id) }}">
									{{ $note->author->full_name ?? 'N/A' }}
								</a>
								<small>{{ $note->created_at->format('Y-m-d h:m A') }}</small>
							</label>
							<p class="m-0">{{ $note->text }}</p>
						</li>
					@endforeach
				</ul>
			@else
				<p class="text-muted m-0">
					<i class="fal fa-info-circle"></i> No information available
				</p>
			@endif
		@endif
	</div>
	@access('drug.note.create', $drug->id)
		<div class="card-footer d-flex justify-content-start">
			<a href="#" class="btn btn-success" data-toggle="modal" data-target="#NoteAdd">
				Add Note
			</a>
		</div>
		<div class="modal fade" id="NoteAdd" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header p-2">
						<h5 class="m-0">
							Add Note to
							<strong>{{ $drug->name }}</strong>
						</h5>
						<button type="button" class="close" data-dismiss="modal"
								aria-label="Close">
							<i class="fal fa-times"></i>
						</button>
					</div>
					<form method="post" action="{{ route('eac.portal.note.create') }}">
						{{ csrf_field() }}
						<input type="hidden" name="subject_id" value="{{$drug->id}}">
						<div class="modal-body p-3">
							<div class="mb-3">
								<label class="d-block">
									{{ \Auth::user()->first_name }} {{ \Auth::user()->last_name }}
									<small>{{date('Y-m-d H:i')}}</small>
								</label>
								<textarea name="text" class="note_text form-control" rows="5"
										  placeholder="Enter note..."></textarea>
							</div>
						</div>
						<div class="modal-footer p-2 d-flex justify-content-between">
							<button type="button" class="btn btn-secondary" data-dismiss="modal"
									tabindex="-1">Cancel
							</button>
							<button type="submit" name="submit" class="btn btn-success"
									value="Add Note">
								Save
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endif
</div>
