<div class="table-responsive">
 <table class="table table-sm SOint">
 	<thead>
  	<tr>
    <th>Title</th>
    <th class="text-center">Public</th>
    {{-- <th class="text-center">Active</th> --}}
    <th class="no-sort"></th>
  	</tr>
 	</thead>
 	<tbody>
  	@foreach($drug->resources->sortBy('name') as $resource)
  		<tr class="{{ $resource->active ? 'v-active' : 'v-inactive'}}">
  			<td>
  				{{ $resource->name }}
      @if($resource->file_id)
      <small class="d-block ml-2">
       <a href="{{ route('eac.portal.file.download', $resource->file_id) }}" class="text-info">
        <i class="fal fa-download text-muted"></i> Resource
       </a>
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