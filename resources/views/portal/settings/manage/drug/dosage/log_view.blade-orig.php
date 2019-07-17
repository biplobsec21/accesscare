@extends('layouts.portal')

@section('title')
 Change Log Entry
@endsection

@section('content')
 <div class="titleBar">
  <nav aria-label="breadcrumb">
   <ol class="breadcrumb">
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.getDashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.settings') }}">Supporting Content</a>
    </li>
    <li class="breadcrumb-item">
     <a href="{{ route('eac.portal.settings.manage.drug.dosage.index') }}">Drug Dosage Manager</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
     @yield('title')
    </li>
   </ol>
  </nav>
  <h2 class="m-0">
   Drug Dosage Manager <small>@yield('title')</small>
  </h2>
 </div><!-- end .titleBar -->

 <div class="actionBar">
  <a href="{{ route($page['logsr']) }}" class="btn btn-secondary">
   <i class="fal fa-key"></i> Return to Change Log
  </a>
 </div><!-- end .actionBar -->

 <div class="viewData">
  <div class="card mb-1 mb-md-4">
   <h5>
    Log list For <span class="text-danger">[{{  \App\Dosage::where('id','=',request()->id)->firstOrFail()->id  }}]</span>
   </h5>
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover SObasic">
     <thead>
      <tr>
       <th>
        ACTION BY
       </th>
       <th width="50%">
        DATA
       </th>
       <th>
        DATE
       </th>       
      </tr>
     </thead>
     <tbody>
      @if($logData)
       @foreach($logData as $val)
       @php $user =   \App\User::where('id','=','$val->user_id')->count(); @endphp
       <tr data-id="{{$val->user_id}}">
        @if($user>0)
         <td>
          {{  \App\User ::where('id','=',$val->user_id)->firstOrFail()->first_name  }} {{  \App\User ::where('id','=',$val->user_id)->firstOrFail()->last_name  }}
         </td>
        @else
         <td>
          <small class="text-muted">N/A</small>
         </td>
        @endif
        <td>
         @php $cng = json_decode($val->desc, true); @endphp
         @foreach($cng as $key=>$cdata)  
          <span style="font-weight: bold;">{{$key}}: </span>  {{$cdata}}<br>
         @endforeach
        </td>
        <td><span class=""> {{ $val->created_at->toDateString() }} </span></td>
       </tr>
       @endforeach
      @endif
     </tbody>
    </table>
   </div>
  </div>
 </div><!-- end .viewData -->

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


