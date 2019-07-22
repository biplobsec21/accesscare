@php $drug = \App\Drug::where('id', $id)->firstOrFail(); @endphp
<h5 class="">Assigned Groups <span class="badge badge-dark">{{$drug->user_groups->count()}}</span></h5>
<div class="pre-scrollable">
	@foreach($drug->user_groups->sortBy('name') as $userGroup)
		<div class="row mb-2 mb-sm-1">
			<div class="col">
				{{$userGroup->name}} ({{$userGroup->type->name}} Group)
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
