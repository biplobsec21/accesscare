<div class="table-responsive">
 <table class="table table-sm SOint">
 	<thead>
  	<tr>
    <th></th>
    <th>Title</th>
    <th class="text-center">Public</th>
    {{-- <th class="text-center">Active</th> --}}
    <th class="no-sort"></th>
  	</tr>
 	</thead>
 	<tbody>
  	@foreach($drug->resources->sortBy('name') as $resource)
  		<tr class="{{ $resource->active ? 'v-active' : 'v-inactive'}}">
     <td class="text-center">
      @if($resource->active === 1)
       <i class="fas fa-circle fa-xs text-success"></i>
       <span class="sr-only">Active</span>
      @else
       <i class="fas fa-circle fa-xs text-light"></i>
      @endif
     </td>
  			<td>
  				{{ $resource->name }}
      @if($resource->file_id)
       <div class="small">
 	      @include('include.portal.file-btns', ['id' => $resource->file_id])
       </div>
      @endif
  			</td>
     <td class="text-center">
      @if($resource->public === 1)
       <i class="far fa-check text-success"></i>
       <span class="sr-only">Public</span>
      @else
       <i class="far fa-times text-light"></i>
      @endif
     </td>
     {{-- <td class="text-center">
      <span class="d-none">@if($resource->active) yes @else no @endif</span>
  				@if($resource->active)
  					<i class="far fa-check text-info"></i>
  				@else
  					<i class="far fa-times text-light"></i>
  				@endif
  			</td> --}}
  			<td>
  				<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#Modal{{ $resource->id }}">
  					Edit
  				</button>
  			</td>
  		</tr>
  	@endforeach
 	</tbody>
 </table>
</div>