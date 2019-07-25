{{--@if(\Auth::user()->notifications()->count() > 0)--}}
<div class="card">
	<div class="card-body">
		<h5 class="text-xl-center">
			<i class="fa-fw fas fa-bell text-success"></i>
			<a href="#" class="text-dark toggleRight">Notifications</a>
		</h5>
		<p class="text-muted mb-0 small text-xl-center">
			View your notifications within the Early Access Care&trade; platform </p>
	</div>
	<div class="d-flex">
		<div class="p-3 h4 mb-0 alert-success">
			<a href="#" class="toggleRight text-success">{{\Auth::user()->notifications()->count()}}</a>
		</div>
		<a href="#" class="toggleRight btn btn-success btn-block btn-lg d-flex justify-content-between align-items-center">
			Notifications
			<i class="fa-fw fas fa-bell"></i>
		</a>
	</div>
</div>