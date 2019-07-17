<div class="row">
	@foreach($drug->components->sortBy('index') as $component)
  <div class="col-lg-6">
   <div class="mb-3">
    <div class="p-2 border-bottom bg-light d-flex justify-content-between">
     <span class="text-monospace text-primary">{{$component->name}}</span>
     <div>
      <a href="#" class="btn btn-sm btn-info window-btn" data-toggle="modal" data-target="#newDosageModal{{ $component->id }}">
       Add Dosage
      </a>
 					@if(!$component->dosages->count())
 						<a class="btn btn-danger btn-sm" href="#" onclick="Confirm_Delete('{{$component->id }}')" data-toggle="tooltip" title="Delete Component">
 							Delete
 						</a>
 					@else
       <span data-toggle="tooltip" title="This component is unable to be deleted as there are items tied to it.">
        <a class="btn btn-danger btn-sm disabled" href="#">
         Delete
        </a>
       </span>
 					@endif
     </div>
    </div>
    @if($component->dosages->where('active', 1)->count())
     <ul class="list-group small border-bottom border-light">
  				@foreach($component->dosages->where('active', 1) as $dosage)
       <li class="list-group-item d-flex justify-content-between">
  						{!! $dosage->display() !!}
        <div>
         <a href="#" data-toggle="modal" data-target="#DosageModal{{ $dosage->id }}">
          <span class="fal fa-fw fa-edit" data-toggle="tooltip" title="Edit Dosage"></span>
         </a>
 								@if(!$dosage->lots->count())
 									<a class="text-danger" href="#" onclick="Delete_Dosage('{{$dosage->id }}')">
           <span class="fal fa-fw fa-times" data-toggle="tooltip" title="Delete Dosage"></span>
 									</a>
 								@else
 									<span data-toggle="tooltip" title="This dosage is unable to be deleted as there are items tied to it.">
           <a class="text-danger disabled" href="#">
            <span class="fal fa-fw fa-times"></span>
           </a>
  								</span>
 								@endif
 							</div>
       </li>
 						@include('include.portal.modals.drugs.dosage.edit')
  				@endforeach
     </ul>
    @endif
   </div><!-- /.row -->
		</div>
  @include('include.portal.modals.drugs.dosage.new')
	@endforeach
</div>
