@extends("layouts.public")


@section("styles")
@endsection

@section("content")
 <div class="section">
  <div class="container">
   <div class="row">
    <div class="col-md-8 order-md-2">
     @foreach($pagesContent as $val)
      @section("title")
      {{ $val->title }}
      @endsection
      {!! $val->content !!}
     @endforeach
    </div>
    <div class="col-md order-md-1 trixcolumn">
     <div class="row">
      <div class="col-sm col-md-12 order-md-2">
       <ul class="nav justify-content-center justify-content-sm-start flex-sm-column">
        <li class="nav-item">
         <a class="nav-link" href="pharmaceutical-portal--pharmaceutical">Pharmaceutical Portal</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="our-expertise--pharmaceutical">Our Expertise</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="single-patient--pharmaceutical">Single Patient</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="multi-patient--pharmaceutical">Multi Patient</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="call-center-service--pharmaceutical">Call Center Service</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="early-access-system-platform-root">Early Access System Platform</a>
        </li>
        <li class="nav-item active">
         <a class="nav-link disabled" href="post-trail-access--pharmaceutical">Post Trial Access </a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="policy-development--pharmaceutical">Policy Development</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="review-committees--pharmaceutical">Review Committees</a>
        </li>
       </ul>
      </div>
      <div class="col-sm col-md-12 order-md-3">
       <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/221607063"></iframe>
       </div>
      </div>
      <div class="d-none d-md-block col-md-12 order-md-1">
       <img src="https://www.earlyaccesscare.com/images/istock-511062060_4.jpg" class="img-fluid" />
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
@endsection

@section("scripts")
@endsection