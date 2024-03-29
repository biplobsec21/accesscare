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
    @if(\Auth::user()->type->name == 'Physician')
     @include('include/portal/physician-navigation')
    @elseif(\Auth::user()->type->name == 'Pharmaceutical')
     @include('include/portal/pharma-navigation')
    @elseif(\Auth::user()->type->name == 'Early Access Care')
     @include('include/portal/eac-navigation')
    @endif
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
       @if(Auth::user()->notifications()->where('read_at', null)->count() > 0 )
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
