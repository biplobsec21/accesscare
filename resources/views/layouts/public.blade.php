<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>
  <title>
   @yield('title') | {{site()->name}}
  </title>
 	<meta property="og:url" content="{{site()->website}}"/>
 	<meta property="og:type" content="website"/>
 	<meta property="og:title" content="{{site()->name}}"/>
 	<meta property="og:description" content="@yield('title')"/>
 	<meta property="og:image" content=""/>
  <link rel="shortcut icon" href="{{ asset('/images/favicon/favicon.ico') }}"/>
  @include('include.stylesheets')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css"/>
  <link rel="stylesheet" href="{{ asset('css/public.css') }}">
  @yield('styles')
  <style>
   .animated {
    animation-delay: 1.75s;
   }
   /*.preload * {
    -moz-transition: none !important;
    -ms-transition: none !important;
    -o-transition: none !important;
    -webkit-animation: unset !important;
    animation: unset !important;
    -webkit-transition: none !important;
    transition: none !important;
   }*/
  </style>
 </head>
 <body id="page-top" class="preload">
  @include('include.public.navbar')
  @yield('precontent')
  <div id="content">
   @yield('frameshow')
   @yield('content')
  </div><!-- end #content -->
  @yield('postcontent')
  <div id="footer" class="section section-dark">
  	<div class="container">
    <div class="row">
     <div class="col-sm">
      <img src="{{ asset('/images/brand_white.png') }}" class="img-fluid mb-2" style="max-height: 60px" />
      <p class="small">{{site()->name}} specializes in Expanded Access (USA) and Compassionate Use (outside of USA). We manage the end to end (request intake to delivery at physician) process.</p>
     </div>
     <div class="col-sm">
      <div class="row ml-0 mr-0 mb-2">
       <div class="d-none d-sm-block col-sm-auto p-0">
        <i class="far fa-fw fa-home"></i>
       </div>
       <div class="col p-0 pl-sm-2">
        <strong class="d-block">Address</strong>
        {{site()->addr1}}<br />
        {{site()->city}}, {{site()->state}} {{site()->zip}}
       </div>
      </div>
      <div class="row ml-0 mr-0 mb-2">
       <div class="d-none d-sm-block col-sm-auto p-0">
        <i class="fa-fw fas fa-phone"></i>
       </div>
       <div class="col p-0 pl-sm-2">
        <strong class="d-block">Telephone</strong>
        <a href="tel:{{site()->phone1}}">
         {{ site()->phone1 }}
        </a>
       </div>
      </div>
      <div class="row ml-0 mr-0 mb-2">
       <div class="d-none d-sm-block col-sm-auto p-0">
        <i class="fa-fw fas fa-envelope"></i>
       </div>
       <div class="col p-0 pl-sm-2">
        <strong class="d-block">Email</strong>
        <a target="_blank" href="mailto:{{site()->email}}">{{site()->email}}</a>
       </div>
      </div>
     </div>
    </div>
    <hr />
  		<div class="copyright text-center">
  			&copy; <?= date('Y') ?> {{site()->name}}
  		</div>
  		<p class="text-center small mt-2">
  			Custom Web Application designed and created by <a href="http://www.quasars.com" target="new" >Quasar Internet Solutions</a>
  		</p>
  	</div>
  </div>
  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
   <i class="fas fa-angle-up"></i>
  </a>
  @include('include.scripts')
  @yield('scripts')
 </body>
</html>
