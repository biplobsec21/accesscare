@extends('layouts.portal')

@section('title')
	Change Log
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
     <a href="{{ route('eac.portal.settings.manage.drug.dosage.strength.index') }}">Formulation Strength Manager</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">
     @yield('title')
    </li>
   </ol>
  </nav>
  <h2 class="m-0">
   Formulation Strength Manager <small>@yield('title')</small>
  </h2>
 </div><!-- end .titleBar -->
 @include('include.alerts')
 <div class="actionBar">
  <a href="{{ route($page['createButton']) }}" class="btn btn-success">
   <i class="fas fa-clipboard-user"></i> Add New
  </a>
  <a href="{{ route($page['listAll']) }}" class="btn btn-primary">
   <i class="fal fa-list"></i> Return to List
  </a>
 </div><!-- end .actionBar -->

 <div class="viewData">
  <div class="card mb-1 mb-md-4">
   <div class="table-responsive">
    <table class="table table-sm table-striped table-hover SObasic">
     <thead>
      <tr>
       <th>
        Label
       </th>
       <th class="text-center">
        Changes
       </th>
       <th>
        Last Updated
       </th>
       <th class="no-sort"></th>
      </tr>
     </thead>
     <tbody>
      @if($logData)
       @foreach($logData as $val)
        <tr data-id="{{$val->id}}">
         <td>
          {{  \App\DosageStrength::where('id','=',$val->id)->firstOrFail()->name  }}
         </td>
         <td class="text-center">
          <span class="badge badge-secondary">{{ $val->total_action }}</span>
         </td>
         <td>{{  \App\DosageStrength::where('id','=',$val->id)->firstOrFail()->updated_at  }}</td>
         <td>
          <a href="{{ route($page['logsviewr'],$val->id) }}">
           <i class="far fa-search-plus" aria-hidden="true"></i> <span class="sr-only">View</span>
          </a>
         </td>
        </tr>
       @endforeach
      @endif

     </tbody>
    </table>
   </div>
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


