<div class="card">
	<div class="card-body">
		<h5 class="text-xl-center">
			<i class="fa-fw fas fa-users text-warning"></i>
			<a class="text-dark" href="{{route('eac.portal.user.list')}}">Platform Users</a>
		</h5>
		<p class="text-muted mb-0 small text-xl-center">
			Create and manage all user types within the Early Access Care&trade; platform.
  </p>
	</div>
 <a href="{{route('eac.portal.user.list')}}" class="btn btn-warning border-0 btn-block h5 mb-0 p-0 d-flex justify-content-between align-items-stretch">
  <div class="p-1 pl-2 pr-2 p-xl-3 alert-warning">
   {{$users->count()}}
  </div>
  <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center flex-fill">
   <span>Platform Users</span>
   <span class="fa-fw fas fa-user"></span>
  </div>
 </a>
</div>