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
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('/images/favicon/android-icon-192x192.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/images/favicon/favicon-16x16.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicon/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('/images/favicon/favicon-96x96.png') }}">
  <link rel="shortcut icon" href="{{ asset('/images/favicon/favicon.ico') }}"/>
  @include('include.stylesheets')
  <link rel="stylesheet" href="{{ asset('css/public.css') }}">
  @yield('styles')
 </head>
 <body id="page-top">
  @include('include.public.header')
  @yield('splash')
  <div id="content">
   @yield('frameshow')
   <div class="container">
    @yield('content')
   </div>
  </div><!-- end #content -->
  <div id="footer" class="section section-dark">
  	<div class="container">
    <div class="row">
     <div class="col-sm-4">
      <img src="{{ asset('/images/brand_white.png') }}" class="img-fluid" style="max-height: 60px" />
      <p class="small">{{site()->name}} specializes in Expanded Access (USA) and Compassionate Use (outside of USA). We manage the end to end (request intake to delivery at physician) process.</p>
      <div class="row ml-0 mr-0 mb-2">
       <div class="col-auto p-0">
        <i class="far fa-fw fa-home"></i>
       </div>
       <div class="col">
        <strong class="d-block">Address</strong>
        40 Mungertown Road<br />
        Madison, CT 06443
       </div>
      </div>
      <div class="row ml-0 mr-0 mb-2">
       <div class="col-auto p-0">
        <i class="far fa-fw fa-phone"></i>
       </div>
       <div class="col">
        <strong class="d-block">Telephone</strong>
        (203) 441-7938
       </div>
      </div>
      <div class="row ml-0 mr-0 mb-2">
       <div class="col-auto p-0">
        <i class="far fa-fw fa-envelope"></i>
       </div>
       <div class="col">
        <strong class="d-block">Email</strong>
        contact@earlyaccesscare.com
       </div>
      </div>
     </div>
     <div class="col-sm-8">
      <ul class="nav flex-column flex-lg-row nav-fill">
       <li class="nav-item">
        <a href="aboutus" class="nav-item text-white">
         About {{site()->name}}
        </a>
        <ul class="list-unstyled ml-3 mb-0">
         <li class="mb-1"><a href="mission">Our Mission</a></li>
         <li class="mb-1"><a href="leadership">Leadership</a></li>
         <li class="mb-1"><a href="news">News</a></li>
         <li class="mb-1"><a href="terms">Terms of Use</a></li>
         <li class="mb-1"><a href="Privacy">Privacy Policy</a></li>
         <li class="mb-1"><a href="faq">Frequently Asked Questions</a></li>
        </ul>
       </li>
       <li class="nav-item">
        <a href="solutions-patients" class="nav-item text-white">
         Patients
        </a>
        <ul class="list-unstyled ml-3 mb-0">
         <li class="mb-1"><a href="patients-experience">Our Expertise</a></li>
         <li class="mb-1"><a href="what-we-do">What We Do For You</a></li>
         <li class="mb-1"><a href="what-is-process">What's The Process?</a></li>
         <li class="mb-1"><a href="helping-patients">Helping Patients</a></li>
         <li class="mb-1"><a href="patients-safety-reporting">Safety Reporting</a></li>
        </ul>
       </li>
       <li class="nav-item">
        <a href="solutions-physicians" class="nav-item text-white">
         Physicians
        </a>
        <ul class="list-unstyled ml-3 mb-0">
         <li class="mb-1"><a href="physician-experience">Our Expertise</a></li>
         <li class="mb-1"><a href="physician-safety-reporting">Safety Reporting</a></li>
        </ul>
       </li>
       <li class="nav-item">
        <a href="solutions-physicians" class="nav-item text-white">
         Pharma Companies
        </a>
        <ul class="list-unstyled ml-3 mb-0">
         <li class="mb-1"><a href="pharmaceutical-experience">Our Expertise</a></li>
         <li class="mb-1"><a href="single-patient">Single Patient</a></li>
         <li class="mb-1"><a href="multi-patient">Multi Patient</a></li>
         <li class="mb-1"><a href="pharmaceutical-call-center">Call Center Service</a></li>
         <li class="mb-1"><a href="eas-platform">Early Access System Platform</a></li>
         <li class="mb-1"><a href="post-trial-access">Post Trial Access </a></li>
         <li class="mb-1"><a href="pharmaceutical-policy-development">Policy Development</a></li>
         <li class="mb-1"><a href="pharmaceutical-review-committees">Review Committees</a></li>
        </ul>
       </li>
      </ul>

     </div>
    </div>
  		<div class="copyright text-center">
  			&copy; <?= date('Y') ?> {{site()->name}}
  		</div>
  		<p class="text-center m-t-20">
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
