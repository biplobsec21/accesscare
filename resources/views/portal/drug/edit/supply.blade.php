<div class="card-body">
	<h5 class="mb-1">
		Drug Distribution Schedule
	</h5>
	<input type="hidden" name="drug_id" value="{{$drug->id}}">
	<div class="table-responsive">
		<!-- Don't make this a DataTable -->
		<table class="table table-sm table-striped">
			<thead>
			<tr>
				<th>Start</th>
				<th>End</th>
				<th>Number Days Supply</th>
				<th class="no-sort"></th>
			</tr>
			</thead>
			<tbody id="intervals">
			</tbody>
		</table>
	</div>
</div>
<div class="card-footer">
	<div class="row align-items-end">
		<div class="col">
			<label class="small upper">
				Starting Visit #
			</label>
			<select class="form-control" id="supply_start_new">
				<option value="1">1</option>
			</select>
		</div>
		<div class="col pl-0 pr-0">
			<label class="small upper">
				Number Days Supply
			</label>
			<select class="form-control" id="supply_qty_new">
				<option hidden value="">-- Select --</option>
				@foreach(config('eac.drug.supplyLengths') as $i)
					<option value="{{$i}}">{{$i}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-auto">
			<a href="#" class="btn btn-success add">
				Save
			</a>
		</div>
	</div><!-- /.row -->
</div>

@section('scripts')
	<script>
        $(document).ready(function () {
            let $lastPeriod = {{$supply_info->sortBy('supply_start')->last()->supply_start ?? 0}};
            const $maxPeriod = {{config('eac.drug.maxIntervalLength')}};

            displayIntervals();

            $(document).on('click', 'a.add', function (e) {
                let $intervals = $('#intervals');
                let $start = $('#supply_start_new');
                let $quantity = $('#supply_qty_new');

                let $id = '';

                $.ajax({
                    type: 'POST',
                    url: "{{ route('eac.portal.drug.supply.add') }}",
                    async: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'drug_id': '{{$drug->id}}',
                        'supply_start': $start.val(),
                        'supply_qty': $quantity.val(),
                    },
                    success: function (d) {
                        $id = JSON.parse(d).supply_id;
                    }
                });
                displayIntervals();
            });

            $(document).on('click', 'a.remove', function (e) {
                let row = e.target.closest('tr');

                $.ajax({
                    type: 'POST',
                    url: "{{ route('eac.portal.drug.supply.remove') }}",
                    async: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'drug_id': '{{$drug->id}}',
                        'id': $(row).attr('data-id'),
                    }
                });
                displayIntervals();
            });

            function displayIntervals() {
                let $intervals = {};
                let $table = $('#intervals');
                let $html = '';
                $.ajax({
                    type: 'POST',
                    url: "{{ route('eac.portal.drug.supply.load') }}",
                    async: false,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'drug_id': '{{$drug->id}}',
                    },
                    success: function (response) {
                        $intervals = JSON.parse(response);
                    }
                });
                let $i = 0;
                while ($i < $intervals.length) {
                    let $interval = $intervals[$i];
                    $html += '<tr data-id="' + $interval.id + '">';
                    $html += '<td>Visit #' + $interval.supply_start + '</td>';
                    $html += '<td>' + (($interval.supply_end != 'Ongoing') ? ('Visit #' + ($interval.supply_end - 1)) : 'Ongoing') + '</td>';
                    $html += '<td>' + $interval.supply_qty + '</td>';
                    if ($i !== 0 || $intervals.length === 1)
                        $html += '<td>' + getControls() + '</td>';
                    else
                        $html += '<td></td>';
                    $html += '</tr>';
                    $i++;
                }
                $table.html($html);
                if ($intervals.length > 0)
                    $lastPeriod = parseInt($intervals[$i - 1].supply_start);
                else
                    $lastPeriod = 0;
                manageStartSelect();
                resetQuantitySelect();
            }

            function getControls() {
                return '<a class="text-danger remove" href="#"><i class="fas fa-times"></i></a>';
            }

            function manageStartSelect() {
                let $select = $('#supply_start_new');
                $select.empty();

                if ($lastPeriod === 0)
                    $select.append('<option value="1">1</option>');
                else
                    for (let $i = 1 + $lastPeriod; $i < 1 + $maxPeriod + $lastPeriod; $i++)
                        $select.append('<option value="' + $i + '">' + $i + '</option>');
            }

            function resetQuantitySelect() {
                let $select = $('#supply_qty_new');
                $select.val("");
            }
        })
	</script>
@append
