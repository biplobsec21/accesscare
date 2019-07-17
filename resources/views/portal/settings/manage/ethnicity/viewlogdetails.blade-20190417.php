@extends('layouts.portal')

@section('title')
 Ethnicity Manager
@endsection

@section('content')

 <div class="titleBar">
  <div class="row justify-content-between">
   <div class="col-md col-lg-auto">
    <h4 class="m-0">Supporting Content:</h4>
    <h2 class="m-0">
     @yield('title')
    </h2>
    @if(!is_null(Auth::user()->last_seen))
     <h6>LAST LOGIN:
      <small>{{ \Carbon\Carbon::parse(Auth::user()->last_seen)->format(config('eac.date_format')) }}</small>
     </h6>
    @endif
   </div>
   <div class="col-md col-lg-auto ml-lg-auto">
    <ol class="breadcrumb">
     <li class="breadcrumb-item">
      <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
     </li>
     <li class="breadcrumb-item">
      <a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
     </li>
     <li class="breadcrumb-item active" aria-current="page">
      @yield('title')
     </li>
    </ol>
<!--    <div class="text-right">
     <button class="btn btn-secondary btn-sm" id="ShowRightSide" href="#">
      Changelog
     </button>
    </div>-->
   </div>
  </div>
 </div><!-- end .titleBar -->
<div class="actionBar">

 <div class="col-md-6 text-left">
  <a href="{{ route('eac.portal.settings.manage.ethnicity.index') }}" class=" btn btn-success" >
   <i class="fas fa-list-ul fa-fw"></i> List all
  </a>
  <a href="{{ route($page['createButton']) }}" class="btn btn-success">
   <i class="fa-fw far fa-file-medical"></i> Add New
  </a>
  <a href="{{ route('eac.portal.settings.manage.ethnicity.loglist') }}" class="btn btn-primary">
   <i class="fal fa-key"></i> Change Log
  </a>
 </div>
 <div class="col-md-6 text-right">

 </div>  
</div><!-- end .actionBar -->
<div class="actionBar m-t-20">
 <div class="">
  <h3>Logs Data</h3>
  <a href="{{ route('eac.portal.settings.manage.ethnicity.loglist') }}" class="btn btn-primary">
   <i class="fas fa-backward"></i> BACK
  </a>
 </div>
</div><!-- end .titleBar -->
<div class="" >
 <div class="card">
  <table class="table table-sm SObasic dt-responsive">
   <thead>
    <tr>
     <th style="text-align:center">
        ID
     </th>
     <th>
      SUBJECT
     </th>
     <th>
      NAME
     </th>
     <th>
      CHANGES
     </th>
       
    </tr>
   </thead>
   <tbody>
     @if($logData)
    @foreach($logData as $val)
    @php $user =   \App\User::where('id','=','$val->user_id')->count(); @endphp
      
    <tr data-id="">
     <td>{{$val->id}}</td>
     
     <td>{{$val->subject_id}}</td>
     @php $cng = json_decode($val->desc, true); @endphp
     <td>
      @php if($user>0){ @endphp
      {{  \App\User::where('id','=',$val->user_id)->firstOrFail()->title  }}.
     {{  \App\User::where('id','=',$val->user_id)->firstOrFail()->first_name  }}

     {{  \App\User::where('id','=',$val->user_id)->firstOrFail()->last_name  }}
     @php
      }
      else{
       echo 'N/A';   
      }
      @endphp
     </td>
     <td>
       @foreach($cng as $key=>$cdata)  
       <span style="font-weight: bold;">{{$key}}: </span>  {{$cdata}}<br>
       @endforeach

     </td>
     <td align="center">
      
     </td>
    </tr>
    
    
     @endforeach
    @endif

   </tbody>
  </table>
 </div>
</div><!-- end .viewData -->
<div class="rightSide">
 right side
</div><!-- end .rightSide -->

<div class="row m-t-10">
 <div class="col-md-12">
  <?php
  if (Session::has('alerts')) {
   $alert = Session::get('alerts');
   $alert_dismiss = view('layouts.alert-dismiss', ['type' => $alert['type'], 'message' => $alert['msg']]);
   echo $alert_dismiss;
  }
  ?>    
 </div> 
</div>
@endsection
@section('scripts')
<script>
 $(document).ready(function () {

  $("#-datatble-").on("click", function () {
   
  });

 });

  
 function ConfirmDelete(param){
    
 }
</script>
@endsection


