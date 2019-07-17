@php
	$drug = \App\Drug::where('id', $id)->firstOrFail();
@endphp
<ul class="list-group list-group-flush m-0">
	@foreach($drug->depots as $depot)
		@if(!$depot)
			@continue
		@endif
		<li class="list-group-item pl-0 pr-0">
			<p class="small">
				<strong class="d-block">{{ $depot->name }}</strong>
				{{ $depot->address->city }} {{ $depot->address->state->name ?? '' }}
				{{$depot->address->country->name ?? ''}}
			</p>
			<div class="table-responsive">
				<table class="table table-sm table-striped">
					<thead>
					<tr>
						<th>Lot #</th>
						<th>Form/Dosage</th>
						<th>Stock</th>
						<th></th>
					</tr>
					</thead>
					<tbody class="depot-lot-list">
					@foreach($depot->lotsWithDrug($drug->id) as $lot)
						<tr>
							<td>
								{{ $lot->number }}
							</td>
							<td>
								{{ $lot->dosage->form->name }} {{ $lot->dosage->amount }}
								<small>{{ $lot->dosage->unit->name }}</small>
							</td>
							<td>
								{{ $lot->stock }} / {{ $lot->minimum }}
							</td>
							<td>
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</li>
	@endforeach
</ul>
@if(!$drug->depots)
	<p class="text-muted m-0">
		<i class="fal fa-info-circle"></i> No information available
	</p>
@endif
@if($drug->lots->where('depot_id', null)->count())
	<p class="text-muted m-0">
		{{$drug->lots->where('depot_id', null)->count()}} lots could not be displayed due to not being assigned to a depot.
	</p>
@endif
