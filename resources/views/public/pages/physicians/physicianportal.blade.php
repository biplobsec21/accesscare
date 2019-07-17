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
        <li class="nav-item active">
         <a class="nav-link disabled" href="physician-portal--physicians">Physician Portal</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="our-expertise--physicians">Our Expertise</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="safety-reporting--physicians">Safety Reporting</a>
        </li>
       </ul>
      </div>
      <div class="col-sm col-md-12 order-md-3">
       <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/221605315"></iframe>
       </div>
      </div>
      <div class="d-none d-md-block col-md-12 order-md-1">
       <img src="https://www.earlyaccesscare.com/images/584204016_lg_2.jpeg" class="img-fluid" />
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
@endsection

@section("scripts")
@endsection