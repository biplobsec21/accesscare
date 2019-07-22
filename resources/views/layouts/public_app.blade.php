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
  <link rel="stylesheet" href="{{ asset('css/public.css') }}">
  @yield('styles')
 </head>
 <body>
  <div id="header">
   <div class="container">
    <div class="row align-items-md-center">
     <div class="col-md-auto">
      <a class="nahtlogo" href="/" aria-label="{{site()->name}}">
       <img src="{{url(site()->logo)}}" alt="{{site()->name}}" style="max-height: var(--logo-height);" />
      </a>
     </div>
     <div class="col col-md-auto ml-md-auto mr-md-auto">
      <span class="navbar-text">
       <span class="d-block upper">Track RID</span>
       Logged in as <strong>{{Session::get('userName')}}</strong>
      </span>
     </div>
     <div class="col-auto ml-md-auto">
      <a href="{{route('eac.auth.ridtrack.patient.logout')}}" class="btn btn-light btn-sm"> 
       Signout
      </a>
     </div>
    </div>
   </div>
  </div><!-- /#header -->
  <div id="content">
   <div class="container">
    @yield('content')
   </div>
  </div><!-- /#content -->
  <div id="footer">
   <div class="container">
    <div class="row align-items-md-center">
     <div class="col-sm">
      <ul class="nav justify-content-center justify-content-sm-start">
       <li class="nav-item">
        <a href="tel:{{site()->phone1}}" class="nav-link">
         <span class="fas small fa-fw fa-phone text-muted"></span> {{ site()->phone1 }}
        </a>
       </li>
       <li class="nav-item">
        <a href="mailto:{{site()->email}}" class="nav-link">
         <span class="fas small fa-fw fa-envelope text-muted"></span> {{site()->email}}
        </a>
       </li>
      </ul>
     </div>
     <div class="col-sm-auto text-center text-sm-right">
      <span class="copyright">
       &copy; <?= date('Y') ?> {{site()->name}}
      </span>
     </div>
    </div>
   </div>
  </div><!-- /#footer -->
  @include('include.scripts')
  @yield('scripts')
 </body>