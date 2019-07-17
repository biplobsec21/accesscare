<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app="eacApp">
<head>
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<title>
		@yield('title') | Early Access Care
	</title>
	<link rel="shortcut icon" href="{{ asset('/images/favicon/favicon.ico') }}"/>
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css"/>
	<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.3/css/bootstrap-select.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.2/dragula.min.css"/>
	<link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css"/>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css"/>
	@include('include.stylesheets')
	<link rel="stylesheet" href="{{ asset('/css/select2-custom.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/portals.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/media.css') }}">
	<link rel="stylesheet" href="{{ asset('/css/forms.css') }}">
	@yield('styles')
 <style>
  body {
   background-image: url(https://media.istockphoto.com/photos/medical-clinic-blur-background-healthcare-hospital-service-center-in-picture-id1023182216);
   background-position: center center;
   background-attachment: fixed;
   background-size: cover;
  }
  #frame {
   position: relative;
   max-width: 1400px;
   height: 100vh;
   background-color: #fff;
  }
  .thatlogo img {
   max-height: 55px;
  }
  #x__header {
   padding: .5rem;
  }
  .sidebar {
   background-color: #fff;
  }
  #x__content {
   border-width: 2px 0px 2px 1px;
   border-style: solid;
   border-color: rgb(210, 222, 232);
   background-color: #f0f4f7;
   padding: 1rem;
  }
 </style>
</head>
@include('include.portal.head-alt')
@include('include.portal.foot-alt')

<body id="page-top">
 <div id="frame" class="d-flex flex-column flex-nowrap align-items-stretch align-content-stretch justify-content-start mr-auto ml-auto">
  <div class="flex-shrink-1">
   <div id="x__header">
    <div class="containter-fluid">
     @yield('topinfo')
    </div><!-- /.container-fluid -->
   </div>
  </div>
  <div class="flex-grow-1">
   <div class="d-flex flex-row flex-nowrap align-items-stretch align-content-stretch justify-content-start h-100">
    <div class="overlay"></div>
    <div class="flex-shrink-1 bg-white">
     <div class="sidebar {{(isset($_COOKIE['sidebar_class']))? $_COOKIE['sidebar_class']: ''}}">
      @yield('sidenav')
     </div>
    </div>
    <div class="w-100 d-flex flex-column">
     <div class="flex-grow-1">
      @yield('emulation')
      @yield('alerts')
      <div id="dispVP" class="collapse">
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
      <div id="x__content">
       @yield('content')
      </div>
     </div>
     <div id="x__footer">
      <div class="copyrightx">
       @yield('copyright')
      </div>
     </div>
    </div>
    <div class="rightSide">
     <button class="toggleRight btn floater" type="button">
      <i class="far fa-times"></i>
     </button>
     @yield('slideout')
    </div><!-- /.rightSide -->
   </div>
  </div>
  <a class="scroll-to-top rounded" href="#page-top">
   <i class="fas fa-angle-up"></i>
  </a>
 </div>



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
