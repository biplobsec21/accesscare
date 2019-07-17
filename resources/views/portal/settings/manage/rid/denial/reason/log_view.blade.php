@extends('layouts.portal')

@section('title')
 Change Log Details
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
      <a href="{{ route('eac.portal.settings.manage.rid.shipment.courier.index') }}">Rid Denial Reason  Manager</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
     @yield('title')
    </li>
   </ol>
  </nav>
  <h2 class="m-0">
   Courier Manager <small>@yield('title')</small>
  </h2>
 </div><!-- end .titleBar -->
 <div class="actionBar">
  <a href="{{ route($page['logsr']) }}" class="btn btn-secondary">
   <i class="fal fa-key"></i> Return to Change Log
  </a>
 </div><!-- end .actionBar -->
 <div class="viewData">
  <div class="card-header p-2">
   <h5 class="m-0">
    Change Log for <strong><u>{{\App\DenialReason::where('id','=',request()->id)->firstOrFail()->name}}</u></strong>
   </h5>
  </div>
  <div class="card mb-1 mb-md-4">
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover SObasic">
     <thead>
      <tr>
       <th>
        Date
       </th>
       <th>
        Change Made By
       </th>
       <th class="no-sort">
        Changes
       </th>
      </tr>
     </thead>
     <tbody>
      {{-- @dd($logData) --}}
      @if($logData)
       @foreach($logData as $val)
        @php $user =   \App\User::where('id','=',$val->user_id)->count(); @endphp
        <tr data-id="{{$val->user_id}}">
         <td>{{$val->created_at->toDateString()}}</td>
         <td>
          @if($user>0)
           {{\App\User::where('id','=',$val->user_id)->firstOrFail()->title}}
           {{\App\User::where('id','=',$val->user_id)->firstOrFail()->first_name}}
           {{\App\User::where('id','=',$val->user_id)->firstOrFail()->last_name}}
          @else
           <small class="text-muted">N/A</small>
          @endif
         </td>
         <td>
          @php $cng = json_decode($val->desc, true); @endphp
          @foreach($cng as $key=>$cdata)
           <div class="small d-block">
            <span class="text-muted">{{$key}}:</span> {{$cdata}}
           </div>
          @endforeach
         </td>
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


