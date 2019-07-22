@if($drug->notes->count() > 0)
 <ul class="list-group list-group-flush m-0">
		@foreach($drug->notes->sortByDesc('created_at') as $note)
   <li class="list-group-item pt-2 pl-0 pr-0 pb-2">
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