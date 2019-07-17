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
         <a class="nav-link" href="patient-portal--patients">Patient Portal</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="patient-portal--patients">Our Expertise</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="what-we-do-for-you--patients">What We Do For You</a>
        </li>
        <li class="nav-item active">
         <a class="nav-link disabled" href="whats-the-process--patients">What's The Process?</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="helping-patients--patients">Helping Patients</a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="safety-reporting--patients">Safety Reporting</a>
        </li>
       </ul>
      </div>
      <div class="col-sm col-md-12 order-md-3">
       <p class="d-none d-sm-block alert alert-info mt-3">
        Our Chief Scientific Officer explains the process to patients in the video below. Transcripts of the video are available in <a title="English" href="/images/EAC-Patient-Video_ENG.pdf" class="text-dark strong" target="_blank">English</a> and <a title="Spanish" href="/images/EAC-Patient-Video_SPN.pdf" class="text-dark strong" target="_blank">Spanish</a> and are available to print.
       </p>
       <div class="embed-responsive embed-responsive-16by9">
        <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/221605315"></iframe>
       </div>
      </div>
      <div class="d-none d-md-block col-md-12 order-md-1">
       <img src="https://www.earlyaccesscare.com/images/istock-535162623.jpg" class="img-fluid" />
      </div>
     </div>
    </div>
   </div>
  </div>
 </div>
@endsection

@section("scripts")
@endsection