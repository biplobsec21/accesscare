@php $drug = \App\Drug::where('id', $id)->firstOrFail(); @endphp
<h5>Components &amp; Dosages</h5>
@if($drug->components->count() > 0)
	<ul class="list-group list-group-flush">
		@foreach($drug->components->sortBy('index') as $component)
			<li class="list-group-item these">
				<ul class="list-unstyled m-0">
					<li class="p-0">
						<span class="badge badge-secondary">
							{{ $component->name }}
						</span>
					</li>
					@foreach($component->dosages as $dosage)
						@if($dosage->active == 1)
							<li class="pr-0">
								{!! $dosage->display_short !!}
							</li>
						@endif
					@endforeach
				</ul>
			</li>
		@endforeach
	</ul>
@else
	<p class="text-muted m-0">
		<i class="fal fa-info-circle"></i> No information available
	</p>
@endif
