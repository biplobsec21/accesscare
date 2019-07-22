<div class="row">
	@foreach($rid->user_groups->sortBy('name') as $userGroup)
  <div class="col-sm-6 mb-3">
   <div class="card h-100 border-light bs-no border">
    <div class="card-body p-3">
     <h6 class="mb-2 strong">
      {{$userGroup->name}} ({{$userGroup->type->name}} Group)
     </h6>
     <ul class="list-unstyled">
    		@foreach($userGroup->users()->sortBy('first_name') as $user)
    			@if($user)
        <li>
    					<a href="{{ route('eac.portal.user.show', $user->id) }}" class="btn btn-link">
    						{{$user->full_name}}
    					</a>
    					<small class="d-block">
          {{$userGroup->roleInTeam($user->id)->name}} @if($user->id == $userGroup->parent_user_id)(Group Lead)@endif
         </small>
    				</li>
    			@endif
    		@endforeach
     </ul>
    </div>
   </div>
  </div>
	@endforeach
</div>
