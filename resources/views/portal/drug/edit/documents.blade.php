@if ($drug->documents->count())
	<div class="table-responsive">
		<table class="table table-sm SOint">
			<thead>
 			<tr>
     <th class="no-sort"></th>
 				<th>Document Type</th>
 				<th>Required</th>
 				<th class="no-sort"></th>
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
 						@if($document->file_id)
								<a href="{{ route('eac.portal.file.download', $document->file_id) }}" class="btn btn-link btn-sm" data-toggle="tooltip" data-placement="bottom" title="Download Template">
									@php try{ echo $document->type->name; } catch (\Exception $e) {} @endphp
								</a>
       @else
       @php try{ echo $document->type->name; } catch (\Exception $e) {} @endphp
 						@endif
 					</td>
      <td class="text-center">
       @if(($document->is_required) && ($document->is_required_resupply))
        <span class="d-xl-block badge badge-outline-dark" data-toggle="tooltip" data-placement="left" title="Upload required for Initial and Resupply Requests">Required</span>
       @elseif($document->is_required_resupply)
        <span class="d-xl-block badge badge-outline-warning" data-toggle="tooltip" data-placement="left" title="Upload required for Resupplies only">Resupplies</span>
       @elseif($document->is_required)
        <span class="d-xl-block badge badge-outline-success" data-toggle="tooltip" data-placement="left" title="Upload required for Initial Request only">Initial Only</span>
       @else
        <span class="d-xl-block badge badge-outline-secondary">Periodic</span>
       @endif
      </td>
 					<td class="text-right">
       <a href="#Modal{{ $document->id }}" class="window-btn" data-toggle="modal" data-target="#Modal{{ $document->id }}">
 							<i class="far fa-edit" data-toggle="tooltip" data-placement="bottom" title="Edit Form"></i> <span class="sr-only">Edit</span>
 						</a>
 					</td>
 				</tr>
 			@endforeach
			</tbody>
		</table>
	</div>

@endif