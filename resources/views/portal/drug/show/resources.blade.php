@php $drug = \App\Drug::where('id', $id)->firstOrFail(); @endphp
<div class="row mb-3">
	<div class="col">
		<h5 class="mb-0">Reference Documents
			<span class="badge badge-dark">{{ $drug->resources->count() }}</span>
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
	<table class="table table-sm cusGem" id="resourceDT">
		<thead>
		<tr>
			<th>Title</th>
			<th class="text-center">Public</th>
			<th class="no-sort"></th>
		</tr>
		</thead>
		<tbody>
		@foreach($drug->resources->sortBy('name') as $resource)
			{{-- @if($resource->active === 0)
			 @continue
			@endif --}}
			<tr class="{{ $resource->active ? 'v-active' : 'v-inactive'}}">
				<td>
					{{ $resource->name }}
					@if($resource->file_id)
						<small class="d-block ml-2">
							@include('include.portal.file-btns', ['id' => $resource->file_id])
						</small>
					@endif
				</td>
				<td class="text-center">
					<span class="d-none">@if($resource->public) yes @else no @endif</span>
					@if($resource->public === 1)
						<i class="far fa-check text-success"></i>
					@else
						<i class="far fa-times text-light"></i>
					@endif
				</td>
				<td class="">
					<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#Resource{{$resource->id}}">
						More Info
					</button>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</div>
@foreach($drug->resources->sortBy('name') as $resource)
	<div class="modal fade" id="Resource{{$resource->id}}" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header p-2">
					<h5 class="m-0">
						<label class="d-block">
							{{ $resource->name }}
						</label>
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="fal fa-times"></i>
					</button>
				</div>
				<div class="modal-body p-3">
					<label class="d-block">
						Type
					</label>
					{{$resource->type && $resource->type->name ? $resource->type->name : ''}}
					<label class="d-block">
						Description
					</label>
					{{$resource->desc}}
					<label class="d-block">
						Status
					</label>
					@if($resource->active)
						<span class="ml-2 badge badge-success">
							Active
						</span>
					@else
						<span class="ml-2 badge badge-light">
							Inactive
						</span>
					@endif
					<label class="d-block">
						Is public
					</label>
					
					@if($resource->public)
						<span class="ml-2 badge badge-dark">
							Yes
						</span>
					@else
						<span class="ml-2 badge badge-light">
							No
						</span>
					@endif
				</div>
				<div class="modal-footer p-2 d-flex justify-content-between">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="0">Cancel</button>
					@include('include.portal.file-btns', ['id' => $resource->file_id])
				</div>
			</div>
		</div>
	</div>
@endforeach
