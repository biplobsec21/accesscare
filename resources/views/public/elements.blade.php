@extends('layouts.public')

@section('content')
 <div class="section">
  <div class="container">
   <div class="row">
    <div class="col-sm">
     <strong>QuasarEsh</strong>'s testing page
    </div>
    <div class="col-sm text-sm-right">
     <pre>{{ date("l, F jS Y") }}</pre>
    </div>
   </div>
   @include('include/elements')
  </div>
 </div>
@endsection