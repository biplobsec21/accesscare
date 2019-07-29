<div id="DONOTREMOVE">
	<div id="wrapper">
		<!-- Sidebar -->
		<div class="sidebar {{(isset($_COOKIE['sidebar_class']))? $_COOKIE['sidebar_class']: ''}} d-flex align-items-stretch flex-column">
			<div class="row align-items-center">
				<div class="col-auto ">
					<a class="navbar-brand" href="{{route('eac.portal.getDashboard')}}">
						<img src="{{asset('/images/logo-enhanced.png')}}" class="img-fluid"/>
					</a>
				</div>
				<div class="col-auto d-xl-none">
					<a class="toggler sidebarToggle m-0 p-0" href="#">
						<i class="fal fa-times text-muted fa-2x"></i>
					</a>
				</div>
			</div>
			<div class="flex-grow-1">
				@include('include/portal/navigation')
			</div>
			<div class="d-flex align-items-end">
				<div class="copyright text-center small p-3">
					<strong class="d-block">&copy; {{site()->establishment}} - {{date('Y')}}
						<br/>{{site()->name}}</strong>
					<small class="d-block text-muted mt-2">Custom application created by
						<a href="#">Quasar Internet Solutions</a>
					</small>
				</div>
			</div>
		</div>
		<div id="content-wrapper" class="d-flex align-items-stretch flex-column">
			<div class="d-none d-print-block mb-2 pl-3 pr-3">
				<div class="d-flex justify-content-between align-items-end">
					<div>
						<span class="h3 m-0">@yield('title')</span>
					</div>
					<img src="{{asset('/images/brand_full.png')}}" class="img-fluid" style="max-height: 60px;"/>
				</div>
				<hr/>
			</div>
			<div class="overlay"></div>
			<nav id="TopNav" class="navbar navbar-expand navbar-light row align-items-center">
				<div class="col-auto d-xl-none">
					<img src="{{asset('/images/logo-enhanced.png')}}" class="img-fluid" style="height: 53px"/>
				</div>
				<div class="col-auto pl-0">
					<a class="toggler sidebarToggle m-0 p-0" href="#">
						<i class="fas fa-bars"></i>
					</a>
				</div>
				<div class="col-auto ml-auto">
					<div class="d-flex justify-content-between">
						<a class="text-dark mr-3 mr-md-4" data-toggle="collapse" href="#dispVP" role="button" aria-expanded="false" aria-controls="dispVP">
							<i class="fal fa-crop-alt"></i>
							Viewport
							<span class="badge badge-danger">temp</span>
						</a>
						<div class="dropdown">
							<a class="text-info " href="#" id="userMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-user text-primary"></i>
								{{--@if(session('is_emulating'))--}}
								{{--<span>--}}
								{{--{{session()->get('emu_data.origin.full_name')}}--}}
								{{--</span>--}}
								{{--@else--}}
								{{--<span>--}}
								{{--{{(isset(Auth::user()->title))? config('eac.user.availableTitle')[Auth::user()->title] : ''}} {{Auth::user()->full_name}}--}}
								{{--</span>--}}
								{{--@endif--}}
								<span>Profile</span>
							</a>
							<div class="dropdown-menu" aria-labelledby="userMenu">
								<a class="dropdown-item" href="{{route('eac.portal.user.show', Auth::user()->id)}}">
									<i class="far fa-cog fa-fw"></i>
									Settings
								</a>
								<a class="dropdown-item" href="#">
									<i class="far fa-clipboard-list fa-fw"></i>
									Activity Log
								</a>
								<a class="dropdown-item" href="{{route('eac.auth.logout')}}">
									<i class="far fa-sign-out-alt fa-fw"></i>
									Logout
								</a>
							</div>
						</div>
						<a class="text-info toggleRight ml-3 ml-md-4" href="#">
							@php $allnotification = \App\Notification::where('user_id','=',(Auth::user()->id))->count(); @endphp
							<i class="fas fa-bell text-primary"></i>
							Notifications
							@if($allnotification > 0 )
								<strong class="badge badge-success">{!! $allnotification !!}</strong>
							@endif
						</a>
					</div>
				</div>
			</nav>
			@if(session('is_emulating'))
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
			@endif
			<div class="container-fluid flex-grow-1" id="cc_main">
				<div class="collapse" id="dispVP">
					<div class="bg-light p-2 text-center">
						Current viewport size:
						<small class="text-danger d-none d-xl-inline-block">
							XL ( &gt;1200px )
						</small>
						<small class="text-danger d-none d-lg-inline-block d-xl-none">
							LARGE ( 992px - 1199px )
						</small>
						<small class="text-danger d-none d-md-inline-block d-lg-none">
							MEDIUM ( 768px - 991px )
						</small>
						<small class="text-danger d-none d-sm-inline-block d-md-none">
							SMALL ( 576px - 767px )
						</small>
						<small class="text-danger d-sm-none">
							base/xsmall ( &lt;575px )
						</small>
					</div>
				</div>
				<div id="pcont">
					@if (session('confirm'))
						<div class="alert alert-success">
							{!! session('confirm') !!}
						</div>
					@endif
					@if (session('warning'))
						<div class="alert alert-warning">
							{!! session('warning') !!}
						</div>
					@endif
					@if (session('alert'))
						<div class="alert alert-danger">
							{!! session('alert') !!}
						</div>
					@endif
					@if(\Auth::user()->type->name == 'Physician' && !Auth::user()->certificate && \Auth::user()->status != 'Registering')
						<div class="alert alert-danger alert-dismissible fade show" role="alert">
							You have not added your professional documents,
							<a href="#">click here to upload.</a>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>@endif
