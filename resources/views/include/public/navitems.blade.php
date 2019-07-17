{{--  parent_menu and there sub menu --}}
@php 
   $rootValue = App\Menu::where('slug','=','root')->first();
   if($rootValue){
    $parent_menu = App\Menu::where('active','=',1)
                            ->where('slug','!=','root')
                            ->where('parent_menu','=',$rootValue->id)
                            ->orderBy('sequence');
   }else{
    $parent_menu = App\Menu::where('active','=',1)
                            ->where('slug','!=','root')
                             ->orderBy('sequence');
   }
   
@endphp
{{-- ****************** Static li************************** --}}
{{-- ******************* <end> Static li********************** --}}

{{-- ****************** Dynamic li ************************** --}}
@if($parent_menu->count() > 0)
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
     <a class="dropdown-item" href="{{ route('eac.public.page',$s_menu->slug ? $s_menu->slug : '' ) }}">{{ $s_menu->name}}</a>
    @endforeach
   </div>
  </li>

 @else 
  <li class="nav-item">
   <a class="nav-link" href="{{ route('eac.public.page',$menu->slug ? $menu->slug : '' ) }}">{{ $menu->name }}</a>
  </li>
 @endif

@endforeach
{{-- ******************<end> Dynamic li ************************** --}}

@else 
{{-- ****************** if no menu found load static li ************************** --}}
<li class="nav-item">
  <a class="nav-link" href="/">Home</a>
 </li>
 <li class="nav-item">
  <a class="nav-link" href="{{route('elements')}}">Elements</a>
 </li>
 <li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="aboutMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   About Us
  </a>
  <div class="dropdown-menu" aria-labelledby="aboutMenu">
   <a class="nav-link" href="elements">[internal] Elements</a>
   <div class="dropdown-divider"></div>
   <a class="dropdown-item" href="aboutus">About {{site()->name}}</a>
   <a class="dropdown-item" href="mission">Our Mission</a>
   <a class="dropdown-item" href="leadership">Leadership</a>
   <a class="dropdown-item" href="news">News</a>
   <a class="dropdown-item" href="terms">Terms of Use</a>
   <a class="dropdown-item" href="Privacy">Privacy Policy</a>
   <a class="dropdown-item" href="faq">Frequently Asked Questions</a>
  </div>
 </li>
 <li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="patientsMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   Patients
  </a>
  <div class="dropdown-menu" aria-labelledby="patientsMenu">
   <a class="dropdown-item highlight" href="solutions-patients">Patient Portal</a>
   <div class="dropdown-divider"></div>
   <a class="dropdown-item" href="patients-experience">Our Expertise</a>
   <a class="dropdown-item" href="what-we-do">What We Do For You</a>
   <a class="dropdown-item" href="what-is-process">What's The Process?</a>
   <a class="dropdown-item" href="helping-patients">Helping Patients</a>
   <a class="dropdown-item" href="patients-safety-reporting">Safety Reporting</a>
  </div>
 </li>
 <li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="physiciansMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   Physicians
  </a>
  <div class="dropdown-menu" aria-labelledby="physiciansMenu">
   <a class="dropdown-item highlight" href="solutions-physicians">Physician Portal</a>
   <div class="dropdown-divider"></div>
   <a class="dropdown-item" href="physician-experience">Our Expertise</a>
   <a class="dropdown-item" href="physician-safety-reporting">Safety Reporting</a>
  </div>
 </li>
 <li class="nav-item dropdown">
  <a class="nav-link dropdown-toggle" href="#" id="pharmaceuticalMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
   Pharmaceutical
  </a>
  <div class="dropdown-menu" aria-labelledby="pharmaceuticalMenu">
   <a class="dropdown-item highlight" href="solutions-pharmaceutical">Pharmaceutical Portal</a>
   <div class="dropdown-divider"></div>
   <a class="dropdown-item" href="pharmaceutical-experience">Our Expertise</a>
   <a class="dropdown-item" href="single-patient">Single Patient</a>
   <a class="dropdown-item" href="multi-patient">Multi Patient</a>
   <a class="dropdown-item" href="pharmaceutical-call-center">Call Center Service</a>
   <a class="dropdown-item" href="eas-platform">Early Access System Platform</a>
   <a class="dropdown-item" href="post-trial-access">Post Trial Access </a>
   <a class="dropdown-item" href="pharmaceutical-policy-development">Policy Development</a>
   <a class="dropdown-item" href="pharmaceutical-review-committees">Review Committees</a>
  </div>
 </li>
 <li class="nav-item">
  <a class="nav-link" href="contact">Contact Us</a>
 </li>  

@endif
       