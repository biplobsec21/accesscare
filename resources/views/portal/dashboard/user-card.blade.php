<div class="card">
	<div class="card-body">
		<h5 class="text-xl-center">
			<i class="fa-fw fas fa-users text-info"></i>
			<a class="text-dark" href="{{route('eac.portal.user.list')}}">User Groups</a>
		</h5>
		<p class="text-muted mb-0 small text-xl-center">
			Establish your user groups within your practice/hospital </p>
	</div>
	<div class="d-flex">
		<div class="p-3 h4 mb-0 alert-info">
			<a href="{{route('eac.portal.user.list')}}" class="text-info">{{$users->count()}}</a>
		</div>
		<a href="{{ route('eac.portal.user.create') }}" class="btn btn-info btn-lg flex-grow-1 d-flex justify-content-between align-items-center">
			Create User
			<i class="fa-fw fas fa-user"></i>
		</a>
	</div>
</div>