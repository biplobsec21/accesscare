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
      <hr />
      @include('include/elements')
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
  <script src="https://cdn.datatables.net/v/dt/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/r-2.2.2/datatables.min.js"></script>
  <script src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.js"></script>
  <script src="{{ asset('/js/ui/jquery-ui.js') }}"></script>
  <script src="{{ asset('/js/dataTables-config.js') }}"></script>
  <script>
   $(document).on("click", ".table tr td:last-child .btn", function () {
    $("tr.selected").removeClass("selected");
    $(this).parents("tr").addClass("selected");
   });
   $(function () {
    $("body").tooltip({selector: '[data-toggle=tooltip]'});
    $("body").popover({selector: '[data-toggle=popover]'});
   });

   function readnotification(nid) {
    $url = 'eac.portal.rid.readnotification';
    $.ajax({
     type: 'POST',
     url: "{{ route('eac.portal.rid.readnotification') }}",
     data: {
      'nid': nid
     },
     success: function (data) {
      window.location.reload();
     }
    });
   }

   $.ajaxSetup({
    headers: {
     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
   });

   $(document).ready(function () {

    $('.select2').select2({
     placeholder: "-- Select --"
    });

    $('.datepicker').datepicker({
     dateFormat: 'yy-mm-dd',
     changeMonth: true,
     changeYear: true,
     beforeShow: function (input, inst) {
      var rect = input.getBoundingClientRect();
      setTimeout(function () {
       inst.dpDiv.css({top: rect.top + 40, left: rect.left + 0});
      }, 0);
     }
    });
    $('.radio-group .radio').click(function () {
     $(this).parent().find('.radio').removeClass('selected');
     $(this).addClass('selected');
     var val = $(this).attr('data-value');
     //alert(val);
     $(this).parent().find('input').val(val);
    });

    var dragula_obj = dragula([$(".drag_container")[0]]);

    tinymce.init({
     selector: '.editor',
     menubar: false,
     plugins: 'code autolink directionality visualblocks visualchars image link media codesample table charmap hr advlist lists wordcount imagetools help',
     toolbar: 'formatselect charmap | bold italic strikethrough | link image media | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent | removeformat | autolink directionality visualchars hr advlist lists wordcount imagetools | table tabledelete tableprops | codesample visualblocks code',
     image_advtab: true,
     powerpaste_word_import: 'clean',
     powerpaste_html_import: 'clean',
     content_css: [
      'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css',
      'https://pro.fontawesome.com/releases/v5.8.1/css/all.css',
      'https://v2adev.earlyaccesscare.com/css/core.css',
      'https://v2adev.earlyaccesscare.com/css/public.css'
     ]
    });
    tinymce.init({
     selector: '.basic-editor',
     menubar: false,
     plugins: 'code autolink link hr lists',
     toolbar: 'bold italic strikethrough | link | alignleft aligncenter alignright alignjustify | numlist bullist | hr lists | code',
     image_advtab: true,
     powerpaste_word_import: 'clean',
     powerpaste_html_import: 'clean',
     content_css: [
      'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css',
      'https://pro.fontawesome.com/releases/v5.8.1/css/all.css',
      'https://v2adev.earlyaccesscare.com/css/core.css',
      'https://v2adev.earlyaccesscare.com/css/public.css'
     ]
    });


    // Toggle the side navigation
    $(".sidebarToggle").on('click', function (e) {
     e.preventDefault();
     $(".sidebar").toggleClass("toggled");
     $(".sidebar").toggleClass("slideout");
     $("body").toggleClass("hack");
     document.cookie = "sidebar_class=" + ($(".sidebar").hasClass("toggled") ? "toggled" : "");
    });

    $(".toggleRight").on('click', function (e) {
     e.preventDefault();
     $("body").toggleClass("ShowASide");
     $(".rightSide").toggleClass("show");
    });

    $(".overlay, .sidebarToggle").on('click', function (e) {
     e.preventDefault();
     $("body").removeClass("ShowASide");
     $("body").removeClass("hack");
     $("body").removeClass("ShowNotifications");
     $(".rightSide").removeClass("show");
     $(".slideDown").removeClass("show");
    });

    $('.SObasic').DataTable({
     responsive: false,
     saveState: true,
     paginationOptions: [10, 25, 50, 75, 100],
     order: [0, "asc"],
     columnDefs: [{
      targets: 'no-sort',
      orderable: false,
     }],
     fnDrawCallback: function () {
      jQuery("input[data-toggle='toggle']").bootstrapToggle();
     }
    });

    $('.resourcesDT').DataTable({
     info: false,
     saveState: true,
     columnDefs: [{
      targets: 'no-sort',
      orderable: false,
     }]
    });

    $('.sortsearch').DataTable({
     // responsive: true,
     info: false,
     saveState: true,
     paging: false,
     columnDefs: [{
      targets: 'no-sort',
      orderable: false,
     }]
    });

    $('.cusGem').DataTable({
     dom: 'rt<"justify-content-between d-flex align-items-center border-top border-light pt-2 mt-1"lfp>',
     // responsive: true,
     saveState: true,
     columnDefs: [{
      targets: 'no-sort',
      orderable: false,
     }]
    });

    // Scroll to top button appear
    $(document).on('scroll', function () {
     var scrollDistance = $(this).scrollTop();
     if (scrollDistance > 100) {
      $('.scroll-to-top').fadeIn();
     } else {
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
   });

   function notificationSingleRead($id) {

    var notificationid = $id;
    console.log(notificationid);
    $.ajax({
     url: "{{route('eac.portal.notifications.read.single')}}",
     method: "POST",
     data: {'notificationid': notificationid},
     success: function (data) {
      console.log(data);
     },
     error: function (errMsg) {
      console.log(errMsg);
     }
    });


   }

   $(document).ready(function () {
    $('.v-active').show();
    $('.v-inactive').hide();

    // keep the tab active and show after submitting form
    var pageHref = jQuery(location).attr('href');

    $('a[data-toggle="pill"]').on('click', function (e) {
     var activeTabId = this.id;
     var getAreaControl = $(this).attr("aria-controls");

     localStorage.setItem('activeTab', activeTabId);
     localStorage.setItem('activeArea', getAreaControl);
     localStorage.setItem('page', pageHref);
    });

    var activeTab = localStorage.getItem('activeTab');
    var activeArea = localStorage.getItem('activeArea');
    var pageName = localStorage.getItem('page');
    if (activeTab && pageName === pageHref && pageName.indexOf("create") === -1) {
     $('.wizardSteps').find('a:first').removeClass('active show');
     var aRc = $('.wizardSteps').find('a:first').attr("aria-controls");
     $("#" + aRc).removeClass('active show');

     $('#' + activeTab).addClass('active');
     $('#' + activeArea).addClass('active show');
    } else {
     $('.wizardSteps').find('a:first').addClass('active show');
     var aRc = $('.wizardSteps').find('a:first').attr("aria-controls");
     $("#" + aRc).addClass('active show');

    }

    //if Url has a hash and there is a tab with the hash value, open that tab
    if (window.location.hash !== "") {
     $('a[href="' + window.location.hash + '"]').click()
    }
   });
   $(window).on('load', function () {
    $('.nav-link').css('pointer-events', 'auto');
   });

   function showactiveOrAll(param) {
    // alert();
    if (param == 1) {
     $('.v-active').show();
     $('.v-inactive').hide();
    }
    if (param == 0) {
     $('.v-active').show();
     $('.v-inactive').show();
    }
   }

   $(document).on('change', 'input[type=file]', function () {
    let name = $(this).val();
    let type = $(this).attr('type');
    $('.file-instruction').remove('');
    $('.invalid-feedback').remove('');
    if (type === 'file') {
     // check file type if wrong show message
     let ext = name.split('.').pop().toUpperCase();
     if (['PDF', 'JPG'].indexOf(ext) === -1) {
      let error_message = ext + " is not a allowed file type. Please try again";
      $(this).addClass('is-invalid');
      $(this).val('');
      $(this).after("<div class='invalid-feedback'>" + error_message + "</div>").focus();
      return false;
     } else {
      $(this).removeClass('is-invalid');
      $(this).removeClass('invalid-feedback');
     }
     // file size
     if (this.files[0].size > 2000000) {
      let error_message = "Files should be less 2MB. Please try again";
      $(this).addClass('is-invalid');
      $(this).val('');
      $(this).after("<div class='invalid-feedback'>" + error_message + "</div>").focus();
      return false;
     } else {
      $(this).removeClass('is-invalid');
      $(this).removeClass('invalid-feedback');
     }
    }
   });
  </script>
  @yield('scripts')
  <script>
   $(function () {
    let activeTab = $('a.dropdown-item.active');
    if (activeTab) {
     let navItem = $('a.dropdown-item.active').parent().parent();
     navItem.children('a').trigger('click');
    }
   });
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


