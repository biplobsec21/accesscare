<div class="modal fade" id="Modal{{ $country->id}}" tabindex="-1" role="dialog" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered modal-md" role="document">
  <div class="modal-content">
   <div class="modal-header p-2">
     <h5 class="m-0">
						Country name {!! $country->name !!}
					</h5>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <i class="fal fa-times"></i>
     </button>
   </div>
   <div class="modal-body p-3">
					<label class="d-block">HAA Info.</label>
					@if($country->haa_info)
					 {!! $country->haa_info !!}
					@else 
					 N/A 
					@endif
					
					<label class="d-block">Notes</label>
					 	@if($country->notes)
					 {!! $country->notes !!}
					@else 
					 N/A 
					@endif
			</div>
		</div>
	</div>
</div>
