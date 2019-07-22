@php $drug = \App\Drug::where('id', $id)->firstOrFail(); @endphp
<div class="row mb-3">
	<div class="col">
		<h5 class="mb-0">Form List
			<span class="badge badge-dark">{{ $drug->documents->count() }}</span>
		</h5>
	</div>
	<div class="col-auto">
		<div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
			<label class="btn btn-secondary active btn-sm" onclick="showactiveOrAll(1)">
				<input type="radio" name="show_active" id="option1" value="1" autocomplete="off">
				View Active
			</label>
			<label class="btn btn-secondary  btn-sm" onclick="showactiveOrAll(0)">
				<input type="radio" name="show_active" id="option2" value="0" autocomplete="off" checked>
				View All
			</label>
		</div>
	</div>
</div>
<div class="table-responsive">
	<table class="table table-sm cusGem" id="DocsDT">
		<thead>
		<tr>
			<th></th>
			<th>Document Type</th>
			<th>Required</th>
		</tr>
		</thead>
		<tbody>
		@foreach($drug->documents as $document)
			<tr class="{{ $document->active ? 'v-active' : 'v-inactive'}}">
				<td>
					@if($document->active)
						<span class="text-success fas fa-circle fa-xs"></span>
					@else
						<span class="text-light fas fa-circle fa-xs"></span>
					@endif
				</td>
				<td>
					{{$document->type->name}}
					@if($document->file_id)
						@include('include.portal.file-btns', ['id' => $document->file_id])
					@endif
				</td>
				<td class="text-center">
					@if(($document->is_required) && ($document->is_required_resupply))
						<span class="d-xl-block badge badge-outline-dark" data-toggle="tooltip" data-placement="left" title="File required for Initial and Resupply Requests">Required</span>
					@elseif($document->is_required_resupply)
						<span class="d-xl-block badge badge-outline-warning" data-toggle="tooltip" data-placement="left" title="File required for Resupplies only">Resupplies</span>
					@elseif($document->is_required)
						<span class="d-xl-block badge badge-outline-success" data-toggle="tooltip" data-placement="left" title="File required for Initial Request only">Initial Only</span>
					@else
						<span class="d-xl-block badge badge-outline-secondary">Periodic</span>
					@endif
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
