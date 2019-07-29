<ul class="list-group list-group-flush">
	@foreach($depots as $depot)
		@if($depot->lotsWithDrug($drug->id))
			<li class="list-group-item pl-0 pr-0">
				<div class="row">
					<div class="col">
						<p class="small">
							<strong class="d-block">{{ $depot->name }}</strong>
							{{ $depot->address->city }} @if($depot->address->state_province){{ $depot->address->state->name }}
							- @endif
							@php try{ echo $depot->address->country->name; } catch (\Exception $e) {} @endphp
						</p>
						@if($depot->lotsWithDrug($drug->id))
							<div class="table-responsive">
								<table class="table table-sm table-striped">
									<thead>
									<tr>
										<th>Component</th>
										<th>Lot #</th>
										<th>Form/Dosage</th>
										<th>Stock</th>
										<th>
										</th>
									</tr>
									</thead>
									<tbody class="depot-lot-list">
									@foreach($depot->lotsWithDrug($drug->id) as $lot)
										<tr>
											<td>{{$lot->dosage->component->name}}</td>
											<td class="small">
												{{ $lot->number }}
											</td>
											<td class="small">
												{{ $lot->dosage->form->name }} {{ $lot->dosage->amount }}<small>{{ $lot->dosage->unit->name }}</small>
											</td>
											<td class="small">
												{{ $lot->stock }} / {{ $lot->minimum }}
											</td>
											<td>
												{{-- <a href="{{route('eac.portal.lot.edit', $lot->id)}}"
												   class="btn btn-info btn-sm btn-block window-btn">
													Edit
												</a> --}}
												<button type="button" class="btn btn-info btn-sm btn-block window-btn"
														data-toggle="modal"
														data-target="#newLotModal{{ $lot->id}}">
													Edit
												</button>
											</td>
										</tr>
										@include('include.portal.modals.drugs.lot.edit',$lot)
									@endforeach
									</tbody>
								</table>
							</div>
						@else
							<small class="d-block text-muted">
								<i class="fal fa-info-circle"></i> No information available
							</small>
						@endif
					</div>
					<div class="col-auto d-none">
						<a href="#" class="btn btn-sm btn-info disabled">
							Edit
						</a>
					</div>
				</div>
			</li>
		@endif
	@endforeach
</ul>
