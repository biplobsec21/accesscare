<div id="header">
 <div class="container">
  <div class="row align-items-md-center">
   <div class="col-auto d-md-none">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
     <i class="fas fa-bars"></i>
    </button>
   </div>
   <div class="col">
    <div class="row align-items-center">
     <div class="col col-sm-auto">
      <a class="logo" href="/" aria-label="{{site()->name}}">
       <img src="{{url(site()->logo)}}" alt="{{site()->name}}" />
      </a>
     </div>
     <div class="col col-sm-auto order-sm-4">
      <ul class="nav justify-content-end flex-row">
       <li class="nav-item">
        <a href="{{ route('eac.auth.getSignIn') }}" class="nav-link">
         <span class="d-none d-sm-inline-block fas small fa-fw fa-lock text-muted"></span> Login
        </a>
       </li>
       <li class="nav-item">
        <a href="{{ route('eac.auth.getSignUp') }}" class="nav-link">
         <span class="d-none d-sm-inline-block fas small fa-fw fa-user-plus text-muted"></span> Register
        </a>
       </li>
      </ul>
     </div>
     <div class="col-sm order-sm-3 d-none d-sm-block">
      <ul class="nav justify-content-center flex-row">
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
    </div>
   </div>
  </div>
  <nav class="navbar navbar-expand-md navbar-light">
   <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-md-auto">
     @include('include.public.navitems')
    </ul>
    <div class="d-sm-none mt-2 mb-0 alert alert-secondary text-dark pt-2">
     <h6 class="strong upper">Contact Us</h6>
     <span class="fas fa-phone text-muted"></span> 
     <a href="tel:{{site()->phone1}}" class="text-dark">
      {{ site()->phone1 }}
     </a><br />
     <span class="fas fa-envelope text-muted"></span> 
     <a href="mailto:{{site()->email}}" class="text-dark">
      {{site()->email}}
     </a>
    </div>
   </div>
  </nav>
 </div>
</div>