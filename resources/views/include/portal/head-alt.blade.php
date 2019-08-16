@section('topinfo')
 <div class="row">
  <div class="col-sm-auto">
   <div class="row">
    <div class="col-auto">
     <a class="thatlogo" href="{{route('eac.portal.getDashboard')}}" aria-label="Dashboard">
      <img src="{{url(site()->logo)}}" alt="{{site()->name}}" class="img-fluid" />
     </a>
    </div>
    <div class="col-auto">
     <a class="toggler sidebarToggle m-0 p-0" href="#">
      <i class="fal fa-bars text-muted fa-2x"></i>
     </a>
    </div>
   </div><!-- /.row -->
  </div>
  <div class="col-sm">
   <ul class="nav justify-content-sm-end">
    <li class="nav-item">
     <a class="nav-link" data-toggle="collapse" href="#dispVP" role="button" aria-expanded="false" aria-controls="dispVP">
      <i class="fal fa-crop-alt"></i>
      Viewport
      <span class="badge badge-danger">temp</span>
     </a>
    </li>
    <li class="nav-item dropdown">
     <a class="nav-link dropdown-toggle" href="#" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-user text-primary"></i>
      <span>Profile</span>
     </a>
     <div class="dropdown-menu" aria-labelledby="userMenu">
      <a class="dropdown-item" href="{{route('eac.portal.user.show', Auth::user()->id)}}">
       <i class="far fa-cog fa-fw"></i> Settings
      </a>
      <a class="dropdown-item" href="#">
       <i class="far fa-clipboard-list fa-fw"></i> Activity Log
      </a>
      <a class="dropdown-item" href="{{route('eac.auth.logout')}}">
       <i class="far fa-sign-out-alt fa-fw"></i> Logout
      </a>
     </div>
    </li>
    <li class="nav-item">
     <a class="nav-link toggleRight" href="#">
      @php $allnotification = \App\Notification::where('user_id','=',(Auth::user()->id))->count(); @endphp
      <i class="fas fa-bell text-primary"></i>
      Notifications
      @if($allnotification > 0 )
       <strong class="badge badge-success">{!! $allnotification !!}</strong>
      @endif
     </a>
    </li>
   </ul>
  </div>
 </div><!-- /.row -->
@endsection

@section('sidenav')
	<ul class="nav navbar-nav ">
		<li class="nav-item">
			<a href="{{route('eac.portal.getDashboard')}}" class="nav-link">
				<i class="fa-fw text-primary fas fa-chart-bar"></i>
				<span>Dashboard</span>
			</a>
		</li>
		<li class="nav-item dropdown">
			<a href="{{route('eac.portal.rid.list')}}" class="nav-link">
				<i class="fa-fw text-primary fas fa-medkit"></i>
				<span>RIDs</span>
			</a>
		</li>
		<li class="nav-item dropdown">
			<a href="{{route('eac.portal.drug.list')}}" class="nav-link">
				<i class="fa-fw text-primary fas fa-capsules"></i>
				<span>Drugs</span>
			</a>
		</li>
		<li class="nav-item dropdown">
			<a href="#" id="DD3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
			   class="nav-link dropdown-toggle">
				<i class="fa-fw text-primary fas fa-user-md"></i>
				<span>Users</span>
			</a>
			<div class="dropdown-menu" aria-labelledby="DD3">
				<a href="{{route('eac.portal.user.list')}}" class="dropdown-item @IndexTab('users')">
					<span>All Users</span>
				</a>
				<a href="{{route('eac.portal.user.group.list')}}" class="dropdown-item @IndexTab('user_groups')">
					<span>User Groups</span>
				</a>
			</div>
		</li>
		<li class="nav-item dropdown">
			<a href="{{route('eac.portal.company.list')}}" class="nav-link">
				<i class="fa-fw text-primary fas fa-hospitals"></i>
				<span>Companies</span>
			</a>
		</li>
		<li class="nav-item dropdown">
			<a href="#" id="DD4" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
			   class="nav-link dropdown-toggle">
				<i class="fa-fw text-primary fas fa-warehouse-alt"></i>
				<span>Shipping</span>
			</a>
			<div class="dropdown-menu" aria-labelledby="DD4">
				<a href="{{route('eac.portal.pharmacist.list.all')}}" class="dropdown-item @IndexTab('pharmacist')">
					<span>Pharmacist</span>
				</a>
				<a href="{{route('eac.portal.pharmacy.list.all')}}" class="dropdown-item @IndexTab('pharmacies')">
					<span>Pharmacies</span>
				</a>
				<a href="{{route('eac.portal.depot.list.all')}}" class="dropdown-item @IndexTab('depots')">
					<span>Depots</span>
				</a>
				<a href="{{route('eac.portal.lot.list.all')}}" class="dropdown-item @IndexTab('lots')">
					<span>Lots</span>
				</a>
			</div>
		</li>
		<li class="nav-item">
			<a href="#" class="nav-link">
				<i class="fa-fw text-primary fas fa-files-medical"></i>
				<span>Reports</span>
			</a>
		</li>
		<li class="nav-item">
			<a href="{{route('eac.portal.settings')}}" class="nav-link @IndexTab('supporting')">
				<i class="fa-fw text-primary fas fa-tools"></i>
				<span>Supporting Content</span>
			</a>
		</li>
	</ul>
@endsection

@if(session('is_emulating'))
 @section('emulation')
		<div id="LIA" class="text-center text-lg-left m-0">
   <div class="row align-items-center">
    <div class="col-auto pr-sm-0">
     Signed in as:
    </div>
    <div class="col-sm-auto">
 				<ul class="nav mb-1 mb-sm-0">
 					@foreach(session('emu_data.history') as $k => $v)
 						@php
 							$user = \App\User::where('id', '=', $v)->firstOrFail();
 						@endphp
 						<li class="nav-item m-l-10">
 							<a href="{{route('eac.auth.emu.stop')}}">
 								<strong>{{$user->full_name}}</strong>
 							</a>
 						</li>
 					@endforeach
 					<li class="nav-item m-l-10">
 						<a href="{{route('eac.portal.user.show', Auth::user()->id)}}">
 							<strong>{{Auth::user()->full_name}}</strong>
 						</a>
 					</li>
 				</ul>
    </div>
    <div class="col-auto ml-auto pl-sm-0">
     <a href="{{route('eac.auth.emu.stop')}}" class="btn btn-sm btn-info">
      Signout of {{Auth::user()->first_name}}
     </a>
    </div>
   </div>
		</div>
 @endsection
@endif

@section('alerts')
	@if (session('confirm'))
		<div class="alert alert-success">
			{{session('confirm')}}
		</div>
	@endif
	@if (session('warning'))
		<div class="alert alert-warning">
			{{session('warning')}}
		</div>
	@endif
	@if (session('alert'))
		<div class="alert alert-danger">
			{{session('alert')}}
		</div>
 @endif
@endsection