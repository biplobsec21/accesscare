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
    <div class="d-none {{-- d-xl-block --}}">
     <ul class="nav navbar-nav mt-0 mb-0">
      <li class="nav-item">
       <a class="nav-link" href="{{route('eac.portal.user.show', Auth::user()->id)}}">
        <i class="fad fa-fw fa-user-cog"></i>
        <span>Account Settings</span>
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link toggleRight" href="#">
        <i class="fad fa-fw fa-bell"></i>
        <span>Notifications</span>
        @if(Auth::user()->notifications()->count() > 0 )
         <strong class="badge badge-primary">{{Auth::user()->notifications()->count()}}</strong>
        @endif
       </a>
      </li>
      <li class="nav-item">
       <a class="nav-link text-white btn btn-warning" href="{{route('eac.auth.logout')}}">
        <i class="fad fa-fw fa-sign-out-alt"></i>
        <span>Logout</span>
       </a>
      </li>
     </ul>
    </div>
    <hr class="m-3 d-none">
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
   <nav id="TopNav" class="navbar navbar-expand navbar-light row align-items-center flex-wrap">
    <div class="col-auto d-xl-none">
     <img src="{{asset('/images/logo-enhanced.png')}}" class="img-fluid" style="height: 53px"/>
    </div>
    <div class="col-auto pl-0">
     <a class="toggler sidebarToggle m-0 p-0" href="#">
      <i class="fas fa-bars"></i>
     </a>
    </div>
    <div class="col-auto ml-auto {{-- d-xl-none --}} p-0">
     <div class="d-flex flex-row flex-wrap align-items-center justify-content-between">
      <a class="ml-3 mr-3 d-flex align-items-center btn-link btn-sm " href="{{route('eac.portal.user.show', Auth::user()->id)}}">
       <i class="fad d-none d-md-inline fa-user-cog mr-1"></i>
       Account Settings
      </a>
      <a class="ml-3 mr-3 d-flex align-items-center btn-link btn-sm toggleRight" href="#">
       <i class="fad d-none d-md-inline fa-bell mr-1"></i>
       Notifications
       @if(Auth::user()->notifications()->count() > 0 )
        <strong class="ml-1 badge-pill badge badge-primary">{{Auth::user()->notifications()->count()}}</strong>
       @endif
      </a>
      <a class="ml-3 mr-3 btn btn-sm btn-warning" href="{{route('eac.auth.logout')}}">
       <i class="fad fa-sign-out-alt"></i>
       Logout
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
     @if (session('error'))
      <div class="alert alert-danger">
       {!! session('error') !!}
      </div>
     @endif
     @if(\Auth::user()->type->name == 'Physician' && !Auth::user()->certificate && \Auth::user()->status != 'Registering')
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
       You have not added your professional documents,
       <a href="{{ route('eac.portal.user.certify')}}">click here to upload.</a>
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
       </button>
      </div>@endif
