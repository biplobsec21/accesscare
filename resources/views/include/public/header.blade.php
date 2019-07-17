<div id="header">
   <div id="lead-nav">
    <div class="container">
     <div class="row justify-content-between">
      <div class="col-sm-auto contact">
       <ul class="nav justify-content-between">
        <li class="nav-item">
         <a class="nav-link" href="tel:(888) 315-5797">(888) 315-5797</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="mailto:info@earlyaccesscare.com">info@earlyaccesscare.com</a>
        </li>
       </ul>
      </div>
      <div class="order-sm-3 order-md-2 col-auto ml-auto mr-auto ml-sm-0 mr-sm-0 other">
       <ul class="nav justify-content-between">
        <li class="nav-item">
         <a href="{{ route('eac.auth.getSignIn') }}" class="nav-link">
          Portal Login
         </a>
        </li>
        <li class="nav-item">
         <a href="{{ route('eac.auth.getSignUp') }}" class="nav-link">
          Register
         </a>
        </li>
       </ul>
      </div>
      <div class="order-sm-2 order-md-3 col-sm-auto d-none d-sm-block social">
       <ul class="nav justify-content-between">
        <li class="nav-item">
         <a href="#" class="nav-link">
          <i class="fab fa-facebook"> </i>
         </a>
        </li>
        <li class="nav-item">
         <a href="#" class="nav-link">
          <i class="fab fa-google"> </i>
         </a>
        </li>
        <li class="nav-item">
         <a href="#" class="nav-link">
          <i class="fab fa-linkedin"></i>
         </a>
        </li>
       </ul>
      </div>
     </div><!-- /.d-flex -->
    </div>
   </div><!-- /#lead-nav -->
   <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
     <a class="navbar-brand" href="#" aria-label="Early Access Care">
      <img src="{{ asset('/images/brand_full.png') }}" alt="Early Access Care" />
     </a>
     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
     </button>
     <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ml-lg-auto">
 {{--  ************************************************* --}}
       {{--  parent_menu and there sub menu --}}
       @php 
          $parent_menu = App\Menu::where('active','=',1)->where('parent_menu','001aefrgth')->orderBy('sequence');
       @endphp

       @foreach($parent_menu as $menu)

        @php
        $sub_menu = App\Menu::where('parent_menu',$menu->id)->orderBy('sequence');
        @endphp

        @if($sub_menu->count() > 0)

         <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="{{ $menu->slug }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
           {{ $menu->name }}
          </a>
          <div class="dropdown-menu" aria-labelledby="{{ $menu->slug }}">
           @foreach($sub_menu as $key=>$s_menu)
              <a class="dropdown-item" href="#">{{ $s_menu->name}}</a>
             @if($key == 0)
              <div class="dropdown-divider"></div>
             @endif
           @endforeach
          </div>
         </li>

        @else 
         <li class="nav-item">
          <a class="nav-link" href="/">{{ $menu->name }}</a>
         </li>
        @endif

       @endforeach    
      </ul>
     </div>
    </div>
   </nav>
  </div>