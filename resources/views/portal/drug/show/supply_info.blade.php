@if($supply_info->count() > 0)
	<ul class="list-group list-group-flush m-0">
		<li class="list-group-item pl-0 pr-0">
			<div class="table-responsive">
				<table class="table table-sm table-striped">
					<thead>
					<tr>
						<th>Start</th>
						<th>End</th>
						<th>Number Days Supply</th>
					</tr>
					</thead>
					<tbody class="depot-lot-list">
					@foreach($supply_info as $val)
						<tr>
							<td>
								Visit #{{ $val->supply_start }}
							</td>
							<td>
								@if($val->supply_end !== 'Ongoing')
									Visit # {{ $val->supply_end - 1 }}
								@else
									Ongoing
								@endif
							</td>
							<td>
								{{ $val->supply_qty }}
							</td>
						</tr>
					@endforeach
					</tbody>
				</table>
			</div>
		</li>
	</ul>
@else
	<p class="text-muted m-0">
		<i class="fal fa-info-circle"></i> No information available
	</p>
@endif
