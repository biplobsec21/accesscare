@if(!$groups->count())
	<div class="bg-white border border-light p-3 h-100">
		<h4 class="strong">
			<a href="{{ route('eac.portal.user.group.create') }}">User Groups</a>
		</h4>
		<p class="flex-grow-1 mb-3">
			You do not have a group, create your user group </p>
		<a href="{{ route('eac.portal.user.group.create') }}" class="btn btn-sm btn-primary">Create Group</a>
	</div>
@else
	<div class="card">
		<div class="card-body">
			<h5 class="text-xl-center">
				<i class="fa-fw fas fa-users text-info"></i>
				<a class="text-dark" href="{{route('eac.portal.user.group.list')}}">User Groups</a>
			</h5>
			<p class="text-muted mb-0 small text-xl-center">
				Establish your user groups within your practice/hospital </p>
		</div>
		<div class="d-flex">
			<div class="p-3 h4 mb-0 alert-info">
				<a href="{{route('eac.portal.user.group.list')}}" class="text-info">{{$groups->count()}}</a>
			</div>
			<a href="{{ route('eac.portal.user.group.create') }}" class="btn btn-info btn-block btn-lg d-flex justify-content-between align-items-center">
				User Groups
				<i class="fa-fw fas fa-users"></i>
			</a>
		</div>
	</div>
@endif