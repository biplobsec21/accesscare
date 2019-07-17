
<h5 class="mb-3">
 User Groups
</h5>
@if($rid->user_groups->count() > 0)
 <div class="pre-scrollablex">
  <div class="row">
  	@foreach($rid->user_groups->sortBy('name') as $userGroup)
    <div class="col-md-6 mb-3">
     <div class="card h-100 border-light bs-no border">
      <div class="card-body pl-3 pr-3 pb-3 pt-2">
       <span class="badge p-0 text-secondary">{{$userGroup->type->name}} Group</span>
       <h6 class="mb-2">
        <strong>{{$userGroup->name}}</strong>
       </h6>
       <div class="row mb-2 mb-lg-1 small">
        <div class="col-sm col-md-12 col-lg">
         <a href="{{ route('eac.portal.user.show', $userGroup->parent->id) }}">
          {{$userGroup->parent->full_name}}
         </a>
        </div>
        <div class="col-sm-5 col-md-12 col-lg-auto">
         Group Lead
        </div>
       </div>
       @foreach($userGroup->users()->sortBy('first_name') as $user)
        @if($user)
        <div class="row mb-2 mb-lg-1 small">
         <div class="col-sm col-md-12 col-lg">
          <a href="{{ route('eac.portal.user.show', $user->id) }}">
           {{$user->full_name}}
          </a>
         </div>
         <div class="col-sm-5 col-md-12 col-lg-auto">
          {{$userGroup->roleInTeam($user->id)->name}}
         </div>
        </div>
        @endif
       @endforeach
      </div>
      <div class="card-footer alert-secondary p-2 text-right">
       <a class="btn btn-danger btn-sm" href="{{route('eac.portal.rid.group.destroy', $userGroup->pivot->id)}}" title="Unassign User Group">
        <i class="far fa-fw fa-times"></i> Unassign
       </a>
      </div>
     </div>
    </div>
  	@endforeach
  </div>
 </div>
@else
 <span class="text-muted">No user groups have been assigned</span>
@endif
@include('include.portal.modals.rid.group.add')
