<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
 <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
   @yield('title') | Early Access Care
  </title>
  <link rel="shortcut icon" href="{{ asset('/images/favicon/favicon.ico') }}"/>
  <!-- Fonts -->
  @include('include/portal/css-plugins') <!-- dataTables (bootstrap & responsive), bootstrap-select, bootstrap-toggle, dragula, smoothness, bootstrap-datepicker, animate, fontawesome -->
  <link rel="stylesheet" href="{{ asset('css/eac-app.css') }}"/>
  @yield('styles')
 </head>
 <body id="page-top">
  <div id="outSide" class="">
   <header>
    <div class="container-fluid">
     <div class="d-flex justify-content-between flex-nowrap align-items-center">
      <div class="d-flex flex-nowrap align-items-center">
       <a class="navbar-brand" href="{{route('eac.portal.getDashboard')}}">
        <img src="{{asset('/images/brand_full.png')}}" class="img-fluid"/>
       </a>
       <a class="toggler toggleLeft m-0 p-0" href="#">
        <i class="fal fa-bars text-muted fa-2x"></i>
       </a>
      </div>
      <ul class="nav align-items-center d-none d-sm-flex">
       <li class="nav-item dropdown mr-2">
        <a class="btn btn-outline-dark btn-sm dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
         <i class="fas fa-user"></i> Account
        </a>
        <div class="dropdown-menu pb-0">
         <a class="dropdown-item" href="#">
          Account Settings
         </a>
         <a class="dropdown-item" href="#">
          Activity Log
         </a>
         <div class="dropdown-divider"></div>
         <a class="btn btn-danger btn-sm ml-2 mr-2 mb-2 d-block" href="#">Logout</a>
        </div>
       </li>
       <li class="nav-item">
        <a href="#" class="btn btn-info toggleRight btn-sm">
         <i class="far fa-bell"></i> Notifications
        </a>
       </li>
      </ul>
     </div>
    </div>
   </header><!-- /header -->
   <div id="wrapper">
    <div id="leftSide" class="aside">
     <nav class="p-3">
      @include('include/portal/navigation')
     </nav>
     <div class="bottom p-3">
      bottom of side
     </div>
    </div><!-- /#aside -->
    <div id="content" class="">
     <div class="container-fluid">
      @yield('content')
      <hr />
      @include('include/elements')
     </div>
    </div><!-- /#content -->
    <div id="rightSide" class="aside">
     <div class="d-flex flex-column align-items-stretch ">
      <div class="pt-3 pl-3 pr-3 flex-shrink-1">
       <h5 class="mb-0">
        <i class="far fa-bell"></i> Notifications
       </h5>
       <code>.containInfo</code> add overflow
      </div>
      <div class="flex-grow-1 p-3">
       <div class="containInfo" style="max-height: 72vh; overflow-y:auto">
        list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />list notifications here<br />
       </div>
      </div>
     </div><!-- /.row -->
     <div class="bottom p-3">
      <a href="#" class="btn btn-sm btn-dark d-lg-block" tabindex="-1">
       <i class="fa-fw far fa-check text-success"></i> Mark All Read
      </a>
     </div>
    </div><!-- /#hideside -->
   </div><!-- /#wrapper -->
  </div>
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
   <i class="fas fa-angle-up fa-2x fa-fw"></i>
  </a>
  <!-- Scripts -->
  @include('include/portal/js-plugins') <!-- jquery, easing, dragula, moment, tinymce, sweetalert, datatabls, select2, bootstrap-toggle -->
  <script src="{{ asset('/js/ui/jquery-ui.js') }}"></script>
  <script src="{{ asset('/js/dataTables-config.js') }}"></script>
  @yield('scripts')
  <script>
   $(function () {
    let activeTab = $('a.dropdown-item.active');
    if (activeTab) {
     let navItem = $('a.dropdown-item.active').parent().parent();
     navItem.children('a').trigger('click');
    }
   })
  </script>
 </body>
 @SetTab('')
</html>