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
				<i class="fa-fw fa-lg fad fa-users text-info"></i>
				<a class="text-dark" href="{{route('eac.portal.user.group.list')}}">User Groups</a>
			</h5>
			<p class="text-muted mb-0 small text-xl-center">
				Establish your user groups within your practice/hospital
   </p>
		</div>
  <a href="{{ route('eac.portal.user.group.create') }}" class="btn btn-info border-0 btn-block h5 mb-0 p-0 d-flex justify-content-between align-items-stretch">
   <div class="p-1 pl-2 pr-2 p-xl-3 alert-info">
    {{$groups->count()}}
   </div>
   <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center flex-fill">
    <span>User Groups</span>
    <span class="fa-fw fas fa-lg fa-users"></span>
   </div>
  </a>
	</div>
@endif