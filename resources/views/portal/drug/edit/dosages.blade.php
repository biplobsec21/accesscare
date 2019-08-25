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
      <a href="#" class="btn btn-sm btn-info window-btn" data-toggle="modal" data-target="#editComponentModal{{$component->id}}">
                Edit 
              
      </a>
      <!-- edit component modal -->
  <div class="modal fade" id="editComponentModal{{$component->id}}" tabindex="-1" role="dialog" aria-hidden="true">
  <form method="post" action="{{ route('eac.portal.drug.modal.component.edit') }}" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header p-2">
          <h5 class="m-0">
            Edit Component
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="fal fa-times"></i>
          </button>
        </div>
        <div class="modal-body p-3">
          <div class="row">
            <div class="col-md mb-3">
              <input type="hidden" name="drug_id" value="{{ $drug->id }}"/>
              <label class="d-block">Name</label>
              <input type="text" name="name" class="form-control" value="{{$component->name}}" required/>
              <input type="hidden" name="componentId" class="form-control" value="{{$component->id}}"/>
            </div>
            @if(!$component->activeDosages->count())
            <div class="col-sm-auto mb-3">
              <label class="d-block">Status</label>
              <input data-field="active" type="checkbox" data-toggle="toggle" data-off="Inactive" data-on="Active" data-onstyle="success" data-offstyle="primary" {{ $component->active == '1' ? 'checked'  : '' }}  data-width="100" data-height="32" name="active"  /> 
            </div>
            
            @endif

    
          </div>
        </div>
        <div class="modal-footer p-2 d-flex justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal" tabindex="-1">Cancel</button>
          <button type="submit" class="btn btn-success">
            Save
          </button>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- end edit component modal -->


 					<!-- @if(!$component->dosages->count()) -->
 						<!-- <a class="btn btn-danger btn-sm" href="#" onclick="Confirm_Delete('{{$component->id }}')" data-toggle="tooltip" title="Delete Component">
 							Delete
 						</a> -->
 					<!-- @else -->
       <!-- <span data-toggle="tooltip" title="This component is unable to be deleted as there are items tied to it.">
        <a class="btn btn-danger btn-sm disabled" href="#">
         Delete
        </a>
       </span> -->
 					<!-- @endif -->
     </div>
    </div>
    @if($component->dosages->where('active', 1)->count())
     <ul class="list-group small border-bottom border-light">
  				@foreach($component->dosages->where('active', 1) as $dosage)
       <li class="list-group-item d-flex justify-content-between">
  						{!! $dosage->display_short !!}
        <div>
         <a href="#" data-toggle="modal" data-target="#DosageModal{{ $dosage->id }}">
          <span class="fal fa-fw fa-edit" data-toggle="tooltip" title="Edit Dosage"></span>
         </a>
 								@if(!$dosage->lots->count())
 									<!-- <a class="text-danger" href="#" onclick="Delete_Dosage('{{$dosage->id }}')">
           <span class="fal fa-fw fa-times" data-toggle="tooltip" title="Delete Dosage"></span>
 									</a> -->
 								@else
 									<!-- <span data-toggle="tooltip" title="This dosage is unable to be deleted as there are items tied to it.">
           <a class="text-danger disabled" href="#">
            <span class="fal fa-fw fa-times"></span>
           </a>
  								</span> -->
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
