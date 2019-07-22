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
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('/images/favicon/android-icon-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicon/favicon-16x16.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('/images/favicon/favicon-96x96.png') }}">
  <link rel="shortcut icon" href="{{ asset('/images/favicon/favicon.ico') }}"/>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans|Open+Sans+Condensed|Poppins|Nunito+Sans" rel="stylesheet" type="text/css">
  @include('include/portal/css-plugins') <!-- dataTables (bootstrap & responsive), bootstrap-select, bootstrap-toggle, dragula, smoothness, bootstrap-datepicker, animate, fontawesome -->
  <link rel="stylesheet" href="{{ asset('css/eac-app.css') }}"/>
  @yield('styles')
 </head>
 <body id="page-top">
  <div class="d-flex flex-nowrap flex-column align-items-stretch vh-100">
   <header class="flex-grow-0">
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
   <div id="wrapper" class="d-flex flex-nowrap flex-grow-1">
    <div id="leftSide" class="aside flex-shrink-1">
     <nav class="p-3">
      @include('include/portal/navigation')
     </nav>
     <div class="bottom p-3">
      bottom of side
     </div>
    </div><!-- /#aside -->
    <div id="content" class="flex-grow-1">
     <div class="container-fluid">
      @yield('content')
     </div>
    </div><!-- /#content -->
    <div id="rightSide" class="aside flex-shrink-1">
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.2.1/js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.1/tinymce.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.js"></script>
  <script src="{{ asset('/js/ui/jquery-ui.js') }}"></script>
  <script>
   (function ($) {
    // Scroll to top button and fixed navigation triggers
    $(document).on('scroll', function () {
     var scrollDistance = $(this).scrollTop();
     if(scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
     }
     else {
      $('.scroll-to-top').fadeOut();
     }
    });
    // Smooth scrolling using jQuery easing
    $(document).on('click', 'a.scroll-to-top', function (event) {
     var $anchor = $(this);
     $('html, body').stop().animate({
      scrollTop: ($($anchor.attr('href')).offset().top)
     }, 1000, 'easeInOutExpo');
     event.preventDefault();
    });
   })(jQuery); // End of use strict*/

   $(".toggleLeft").on('click', function (e) {
    e.preventDefault();
    $("body").toggleClass("ShowASide");
    $("#leftSide").toggleClass("show");
   });

   $(".toggleRight").on('click', function (e) {
    e.preventDefault();
    $("body").toggleClass("ShowASide");
    $("#rightSide").toggleClass("show");
   });
   $(function () {
    let activeTab = $('a.dropdown-item.active');
    if (activeTab) {
     let navItem = $('a.dropdown-item.active').parent().parent();
     navItem.children('a').trigger('click');
    }
   });
  </script>
  @yield('scripts')
 </body>
 @SetTab('')
</html>


