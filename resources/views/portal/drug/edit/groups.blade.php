<h5 class="text-gold mb-2">Assigned Groups</h5>
<div class="pre-scrollable">
	@foreach($drug->user_groups->sortBy('name') as $userGroup)
		<div class="row mb-2 mb-sm-1">
			<div class="col">
				{{$userGroup->name}} ({{$userGroup->type->name}} Group)
			</div>
			<div class="col-auto mr-2">
				<a class="text-danger" href="{{route('eac.portal.drug.group.destroy', $userGroup->pivot->id)}}" title="Unassign User Group">
					<i class="fas d-none d-sm-inline fa-times"></i>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-sm mb-2 mb-sm-1 mr-2">
				<a href="{{ route('eac.portal.user.show', $userGroup->parent->id) }}">
					{{$userGroup->parent->full_name}}
				</a>
			</div>
			<div class="col-auto mb-2 mb-sm-1 mr-2">
				<small>Group Lead</small>
			</div>
		</div>
		@foreach($userGroup->users()->sortBy('first_name') as $user)
			<div class="row">
				<div class="col-sm mb-2 mb-sm-1">
					<a href="{{ route('eac.portal.user.show', $user->id) }}">
						{{$user->full_name}}
					</a>
				</div>
				<div class="col-auto mb-2 mb-sm-1 mr-2">
					<small>{{$userGroup->roleInTeam($user->id)->name}}</small>
				</div>
			</div>
		@endforeach
		<br/>
	@endforeach
</div>
<br/>
<button type="button" class="btn btn-dark btn-sm window-btn" data-toggle="modal"
		data-target="#addDrugTeam">
	Assign User Group
</button>
@include('include.portal.modals.drugs.group.add')
