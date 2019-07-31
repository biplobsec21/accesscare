{{--@if(\Auth::user()->notifications()->count() > 0)--}}
<div class="card">
	<div class="card-body">
		<h5 class="text-xl-center">
			<i class="fa-fw fa-lg fad fa-bell text-success"></i>
			<a href="#" class="text-dark toggleRight">Notifications</a>
		</h5>
		<p class="text-muted mb-0 small text-xl-center">
			View unread notifications within the Early Access Care&trade; platform </p>
	</div>
 @php $allnotification = \App\Notification::where('user_id','=',(Auth::user()->id))->where('read_at', null)->count(); @endphp
 <a href="#" class="toggleRight btn btn-success border-0 btn-block h5 mb-0 p-0 d-flex justify-content-between align-items-stretch">
  <div class="p-1 pl-2 pr-2 p-xl-3 alert-success">
   {!! $allnotification !!}
  </div>
  <div class="p-1 pl-2 pr-2 p-xl-3 d-flex justify-content-between align-items-center flex-fill">
   <span>Unread Notifications</span>
   <span class="fa-fw fas fa-lg fa-bell"></span>
  </div>
 </a>
</div>