<h5 class="text-gold mb-2">
	Regimen &amp; Frequency
</h5>
@php $i = 0 @endphp
<div class="row">
	<div class="col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
		@if($rid->drug->components->count() <= $shipment->regimen->count())
			<span class="badge badge-success ">
				<i class="fas fa-check"></i> Complete!
			</span>
		@else
			<span class="badge badge-danger">
				<i class="fas fa-exclamation-triangle"></i> Incomplete
			</span>
		@endif
	</div>
	<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
		<small class="upper d-block">Components</small>
		<strong>{{$rid->drug->components->count()}}</strong>
	</div>
	<div class="col col-md-auto col-lg-3 mb-2 col-xl-auto text-lg-center">
		<small class="upper d-block">Regimens</small>
		<strong>{{$shipment->regimen->count()}}</strong>
	</div>
</div>
<div class="table-responsive">
	<table class="table cusGem table-sm table-striped table-hover">
		<thead>
		<tr>
			<th>Component</th>
			<th>Regimen</th>
			<th>Depot</th>
			<th class="no-sort"></th>
		</tr>
		</thead>
		<tbody>
		@foreach($rid->drug->components->sortBy('index') as $component)
			@php $i++ @endphp
			<tr>
				<td>
					<span class="badge badge-outline-dark">{{$component->name}}</span>
				</td>
				@if($regimen = $shipment->regimenWithComponent($component->id))
					@if($regimen->is_applicable == 1)
						<td>
							<strong class="d-block">
								{{(int)$regimen->lot->dosage->amount * (int)$regimen->quantity}}{{$regimen->lot->dosage->unit->name}}
								{{$regimen->lot->dosage->form->name}}
							</strong>
							taken every {{$regimen->frequency}}
							for {{$regimen->length}}
							<small>({{ $regimen->lot->dosage->strength->name }})</small>
						</td>
						<td>
							@if($regimen->lot->depot)
								<span class="d-block">{{ $regimen->lot->depot->name }}</span>
							@endif
							@if($regimen->lot->number)
								<small>
									Lot:
									<span>{{ $regimen->lot->number }}</span>
								</small>
							@endif
						</td>
					@endif
					@if($regimen->is_applicable == 0)
						<td class="text-muted">N/A</td>
						<td class="text-muted">N/A</td>
					@endif
					<td class="text-right">
						<a href="#" class="" data-toggle="modal" data-target="#Modal{{ $regimen->id }}">
							<i class="far fa-fw fa-edit"></i> <span class="sr-only">Edit</span>
						</a>
					</td>
				@else
					<td></td>
					<td></td>
					<td class="text-right">
						<a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
						   data-target="#newRegimen{{$i}}Modal{{ $shipment->id }}">
							<i class="fal fa-fw fa-plus"></i> Add Regimen
						</a>
					</td>
				@endif
			</tr>
			@if($shipment->regimenWithComponent($component->id))
				@include('include.portal.modals.rid.regimen.edit')
			@else
				@include('include.portal.modals.rid.regimen.new')
			@endif
		@endforeach
		</tbody>
	</table>
</div>
